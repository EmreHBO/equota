<?php

namespace App\Resources;

use App\Entity\Leave;
use App\Entity\Staff;
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
    private static $instance;

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
     * @param $deletedAt
     * @return bool
     * @throws \Doctrine\ORM\Exception\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addLeave($staff, $startDate, $endDate, $deletedAt): bool
    {
        /** @var LeaveRepository $repository */

        $manager = $this->getManager();
        $item = new Leave();
        $item->setStaffId($staff);
        $item->setStartDate($startDate);
        $item->setEndDate($endDate);
        $item->setCreatedAt(new DateTime('now'));
        $item->setUpdatedAt(new DateTime('now'));
        $item->setDeletedAt($deletedAt);
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
        $result->setDeletedAt(new DateTime('now'));
        $manager->flush();
        return true;
    }

    /**
     * @param Request $request
     * @return bool
     * @throws \Doctrine\ORM\Exception\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateLeave(Staff $staff, Request $request): bool
    {
        $id = $request->get('id');
        $manager = $this->getManager();
        $staffMember = $this->getLeave($id);
        $staffMember->setStaffId($staff);
        $staffMember->setStartDate($request->get('startDate'));
        $staffMember->setEndDate($request->get('endDate'));
        $staffMember->setUpdatedAt(new DateTime('now'));
        $manager->persist($staffMember);
        $manager->flush();
        return true;
    }


}