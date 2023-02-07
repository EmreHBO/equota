<?php

namespace App\Controller;

use App\Entity\Staff;
use App\Resources\LeaveResource;
use App\Resources\StaffResource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LeaveController extends AbstractController
{

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\Exception\ORMException
     */
    #[Route('/add-leave', name: 'add_leave')]
    public function insert(ContainerInterface $container, Request $request): Response
    {
        $staff = StaffResource::getInstance($container)->getStaffMember($request->get('staffId'));
        $startDate = $request->get('startDate');
        $endDate = $request->get('endDate');
        $deletedAt = $request->get('deletedAt') ?? null;
        LeaveResource::getInstance($container)->addLeave($staff, $startDate, $endDate, $deletedAt);
        $response = new Response();
        $response->setContent('Kayıt başarılı')->setStatusCode(201);
        return new Response($response);
    }

    /**
     * @param ContainerInterface $container
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\Exception\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    #[Route('/edit-leave', name: 'edit_leave')]
    public function update(ContainerInterface $container, Request $request): Response
    {
        $staff = StaffResource::getInstance($container)->getStaffMember($request->get('staffId'));
        LeaveResource::getInstance($container)->updateLeave($staff, $request);
        $response = new Response();
        $response->setContent('Güncelleme başarılı')->setStatusCode(201);
        return new Response($response);
    }

    /**
     * @param ContainerInterface $container
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\Exception\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    #[Route('/remove-leave', name: 'remove_leave')]
    public function remove(ContainerInterface $container, Request $request): Response
    {
        $id = $request->get('id');
        LeaveResource::getInstance($container)->setLeaveStatus($id);
        $response = new Response();
        $response->setContent('Silme başarılı')->setStatusCode(200);
        return new Response($response);
    }


}
