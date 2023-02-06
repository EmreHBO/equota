<?php

namespace App\Controller;

use App\Resources\StaffResource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FilterController extends AbstractController
{
    #[Route('/get-data-by-filter', name: 'get_data_by_filter')]
    public function index(ContainerInterface $container, Request $request): JsonResponse
    {
        $name = $request->get('name');
        $surname = $request->get('surname');
        $dateStart = $request->get('dateStart');
        $dateEnd = $request->get('dateEnd');

        $staff = StaffResource::getInstance($container)->getStaff();

        return new JsonResponse(['name' => $staff]);
    }


}
