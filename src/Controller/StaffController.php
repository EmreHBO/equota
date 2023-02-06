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
    #[Route('/emre', name: 'blog_list')]
    public function index(ContainerInterface $container): JsonResponse
    {

        $staff = StaffResource::getInstance($container)->getStaff();

            return new JsonResponse(['name' => $staff]);
    }

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
        $endDate = $request->get('endDate');
        $deletedAt = $request->get('deletedAt');
        StaffResource::getInstance($container)->addStaffMember($name, $surname, $sgkNo, $tcNo, $department, $startDate, $endDate, $deletedAt);
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
    #[Route('/edit-staff-member', name: 'edit_staff_member')]
    public function update(ContainerInterface $container, Request $request): Response
    {
        StaffResource::getInstance($container)->updateStaffMember($request);
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
    #[Route('/remove-staff-member', name: 'remove_staff_member')]
    public function remove(ContainerInterface $container, Request $request): Response
    {
        $id = $request->get('id');
        StaffResource::getInstance($container)->setStaffMemberDeletedAt($id);
        $response = new Response();
        $response->setContent('Silme başarılı')->setStatusCode(200);
        return new Response($response);
    }


}
