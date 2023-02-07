<?php

namespace App\Controller;

use App\Resources\StaffResource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaffController extends AbstractController
{

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\Exception\ORMException
     */
    #[Route('/add-staff-member', name: 'add_staff_member')]
    public function insert(ContainerInterface $container, Request $request): Response
    {
        $name = $request->get('name');
        $surname = $request->get('surname');
        $sgkNo = $request->get('sgkNo');
        $tcNo = $request->get('tcNo');
        $department = $request->get('department');
        $startDate = $request->get('startDate');
        $endDate = $request->get('endDate') ?? null;
        $deletedAt = $request->get('deletedAt') ?? null;
        $result = StaffResource::getInstance($container)->addStaffMember($name, $surname, $sgkNo, $tcNo, $department, $startDate, $endDate, $deletedAt);
        $message = empty($result) ? 'Kayıt Başarısız' : 'Kayıt başarılı';

        return new JsonResponse([
            'message' => $message,
        ], 201);
    }

    /**
     * @param ContainerInterface $container
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\Exception\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    #[Route('/edit-staff-member', name: 'edit_staff_member')]
    public function update(ContainerInterface $container, Request $request): Response
    {
        $result = StaffResource::getInstance($container)->updateStaffMember($request);
        $message = empty($result) ? 'Güncelleme Başarısız' : 'Güncelleme Başarılı';

        return new JsonResponse([
            'message' => $message,
        ], 201);
    }

    /**
     * @param ContainerInterface $container
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\Exception\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    #[Route('/remove-staff-member', name: 'remove_staff_member')]
    public function remove(ContainerInterface $container, Request $request): Response
    {
        $id = $request->get('id');
        $result = StaffResource::getInstance($container)->setStaffMemberDeletedAt($id);
        $message = empty($result) ? 'Silme Başarısız' : 'Silme Başarılı';

        return new JsonResponse([
            'message' => $message,
        ], 201);
    }


}
