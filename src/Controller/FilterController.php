<?php

namespace App\Controller;

use App\Repository\LeaveRepository;
use App\Repository\StaffRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FilterController extends AbstractController
{
    #[Route('/get-data-by-filter', name: 'get_data_by_filter')]
    public function index(ManagerRegistry $doctrine, Request $request, LeaveRepository $leaveRepository, StaffRepository $staffRepository): JsonResponse
    {
        $nameOrSurname = $request->get('nameOrSurname');
        $dateStart = $request->get('dateStart');
        $dateEnd = $request->get('dateEnd');
        $onLeave = $request->get('onLeave');

        $data = $staffRepository->findStaffByFilter($nameOrSurname, $dateStart, $dateEnd, $onLeave);
        $message = empty($data) ? 'Uygun Veri Bulunamamıştır' : 'Veriler Listelenmiştir';

        return new JsonResponse([
            'message' => $message,
            'data' => $data
        ], 200);
    }


}
