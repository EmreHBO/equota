<?php

namespace App\Resources;

use App\Entity\Staff;
use App\Repository\StaffRepository;
use App\Traits\ResourceTrait;
use DateTime;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 */
class StaffResource
{
    use ResourceTrait;

    /**
     * @var
     */
    private static StaffResource $instance;

    /**
     * @param ContainerInterface $container
     * @return StaffResource
     */
    public static function getInstance(ContainerInterface $container): StaffResource
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
     * @return Staff[]
     */
    public function getStaff(): array
    {
        /** @var StaffRepository $repository */
        $repository = $this->getRepository(Staff::class);

        return $repository->findAll();
    }

    /**
     * @param int $id
     * @return Staff
     */
    public function getStaffMember(int $id): Staff
    {
        /** @var StaffRepository $repository */
        $repository = $this->getRepository(Staff::class);

        return $repository->find($id);
    }

    /**
     * @param $name
     * @param $surname
     * @param $sgkNo
     * @param $tcNo
     * @param $department
     * @return bool
     * @throws \Doctrine\ORM\Exception\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addStaffMember( $name, $surname, $sgkNo, $tcNo, $department, $startDate, $endDate): bool
    {
        /** @var StaffRepository $repository */

        $manager = $this->getManager();
        $item = new Staff();
        $item->setName($name);
        $item->setSurname($surname);
        $item->setSgkNo($sgkNo);
        $item->setTcNo($tcNo);
        $item->setDepartment($department);
        $item->setStartDate($startDate);
        $item->setEndDate($endDate);
        $item->setCreatedAt(new DateTime('now'));
        $item->setUpdatedAt(new DateTime('now'));
        $item->setIsActive('1');
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
    public function setStaffMemberStatus(int $id): bool
    {
        $manager = $this->getManager();
        $result = $manager->getRepository(Staff::class)->find($id);
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
    public function updateStaffMember(Request $request): bool
    {
        $id = $request->get('id');

        $manager = $this->getManager();
        $staffMember = $this->getStaffMember($id);
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