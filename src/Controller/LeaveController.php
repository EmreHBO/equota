<?php

namespace App\Controller;

use App\Entity\Staff;
use App\Resources\LeaveResource;
use App\Resources\StaffResource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LeaveController extends AbstractController
{

    /**
     * @param ContainerInterface $container
     * @param Request $request
     * @return JsonResponse
     * @throws \Doctrine\ORM\Exception\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    #[Route('/add-leave', name: 'add_leave')]
    public function insert(ContainerInterface $container, Request $request): JsonResponse
    {
        $staff = StaffResource::getInstance($container)->getStaffMember($request->get('staffId'));
        $startDate = $request->get('startDate');
        $endDate = $request->get('endDate');
        $deletedAt = $request->get('deletedAt') ?? null;
        $result = LeaveResource::getInstance($container)->addLeave($staff, $startDate, $endDate, $deletedAt);
        $message = empty($result) ? 'Kayıt Başarısız' : 'Kayıt başarılı';

        return new JsonResponse([
            'message' => $message,
        ], 201);
    }

    /**
     * @param ContainerInterface $container
     * @param Request $request
     * @return JsonResponse
     * @throws \Doctrine\ORM\Exception\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    #[Route('/edit-leave', name: 'edit_leave')]
    public function update(ContainerInterface $container, Request $request): JsonResponse
    {
        $staff = StaffResource::getInstance($container)->getStaffMember($request->get('staffId'));
        $result = LeaveResource::getInstance($container)->updateLeave($staff, $request);
        $message = empty($result) ? 'Güncelleme Başarısız' : 'Güncelleme Başarılı';

        return new JsonResponse([
            'message' => $message,
        ], 201);
    }

    /**
     * @param ContainerInterface $container
     * @param Request $request
     * @return JsonResponse
     * @throws \Doctrine\ORM\Exception\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    #[Route('/remove-leave', name: 'remove_leave')]
    public function remove(ContainerInterface $container, Request $request): JsonResponse
    {
        $id = $request->get('id');
        $result = LeaveResource::getInstance($container)->setLeaveStatus($id);
        $message = empty($result) ? 'Silme Başarısız' : 'Silme Başarılı';

        return new JsonResponse([
            'message' => $message,
        ], 201);
    }


}
