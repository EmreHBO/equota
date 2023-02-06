<?php

namespace App\Resources;

use App\Entity\Leave;
use App\Repository\LeaveRepository;
use App\Traits\ResourceTrait;
use DateTime;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 */
class LeaveResource
{
    use ResourceTrait;

    /**
     * @var
     */
    private static LeaveResource $instance;

    /**
     * @param ContainerInterface $container
     * @return LeaveResource
     */
    public static function getInstance(ContainerInterface $container): LeaveResource
    {
        if (self::$instance == null) {
            self::$instance = new self($container);
        }

        return self::$instance;
    }

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param int $id
     * @return Leave
     */
    public function getLeave(int $id): Leave
    {
        /** @var LeaveRepository $repository */
        $repository = $this->getRepository(Leave::class);

        return $repository->find($id);
    }

    /**
     * @param $staffId
     * @param $startDate
     * @param $endDate
     * @return bool
     * @throws \Doctrine\ORM\Exception\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addLeave($staffId, $startDate, $endDate): bool
    {
        /** @var LeaveRepository $repository */

        $manager = $this->getManager();
        $item = new Leave();
        $item->setStaffId($staffId);
        $item->setStartDate($startDate);
        $item->setEndDate($endDate);
        $item->setCreatedAt(new DateTime('now'));
        $item->setUpdatedAt(new DateTime('now'));
        $item->setDeletedAt();
        $manager->persist($item);
        $manager->flush();
        return true;

    }

    /**
     * @param int $id
     * @return bool
     * @throws \Doctrine\ORM\Exception\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function setLeaveStatus(int $id): bool
    {
        $manager = $this->getManager();
        $result = $manager->getRepository(Leave::class)->find($id);
        $result->setIsActive(0);
        $manager->flush();
        return true;
    }

    /**
     * @param Request $request
     * @return bool
     * @throws \Doctrine\ORM\Exception\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateLeave(Request $request): bool
    {
        $id = $request->get('id');

        $manager = $this->getManager();
        $staffMember = $this->getLeave($id);
        $staffMember->setName($request->get('name'));
        $staffMember->setSurname($request->get('surname'));
        $staffMember->setSgkNo($request->get('sgkNo'));
        $staffMember->setTcNo($request->get('tcNo'));
        $staffMember->setDepartment($request->get('department'));
        $staffMember->setStartDate($request->get('startDate'));
        $staffMember->setEndDate($request->get('endDate'));
        $staffMember->setUpdatedAt(new DateTime('now'));
        $manager->persist($staffMember);
        $manager->flush();
        return true;
    }


}