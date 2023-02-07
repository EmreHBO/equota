<?php

namespace App\Repository;

use App\Entity\Leave;
use App\Entity\Staff;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Staff>
 *
 * @method Staff|null find($id, $lockMode = null, $lockVersion = null)
 * @method Staff|null findOneBy(array $criteria, array $orderBy = null)
 * @method Staff[]    findAll()
 * @method Staff[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StaffRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Staff::class);
    }

    public function save(Staff $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Staff $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Staff[] Returns an array of Staff objects
     */
    public function findStaffByFilter(string $nameOrSurname = null, string $startDate = null, string $endDate = null, $onLeave = null): array
    {
        $queryBuilder = $this->createQueryBuilder('s');

        $nameOrSurname = str_replace(' ', '', $nameOrSurname);

                    $query = $queryBuilder->select([
                        's.name',
                        's.surname',
                        's.tc_no',
                        's.sgk_no',
                        's.start_date as work_start_date',
                        's.end_date as work_end_date',
                        'l.start_date as leave_start_date',
                        'l.end_date as leave_end_date'
                    ])->innerJoin('s.leaves', 'l');

        if(!empty($startDate) && !empty($endDate)){
            $parameters = [
                'filter_start_date' => $startDate,
                'filter_end_date' => $endDate,
            ];
            if($onLeave !== null){
                if($onLeave == 1){ // İzinli
                    $query = $query->andWhere('l.start_date >= :filter_start_date')
                        ->andWhere('l.end_date <= :filter_end_date');
                } elseif ($onLeave == 0){
                    $query = $query->andWhere('l.start_date <= :filter_start_date')
                        ->andWhere('l.end_date >= :filter_end_date');
                }
            }
            else{
                $query = $query->andwhere('l.start_date >= :filter_start_date')
                    ->andWhere('l.end_date <= :filter_end_date');
            }
            $query = $query->setParameters($parameters);
        }
        if(!empty($nameOrSurname)){
            $parameters['name_or_surname'] = "%$nameOrSurname%";
            $query = $query->andWhere('CONCAT(s.name, s.surname) LIKE :name_or_surname');
            $query = $query->setParameters($parameters);
        }

        $query->andWhere('s.deleted_at IS NULL')
            ->andWhere('l.deleted_at IS NULL');

        return $query->getQuery()->execute();

    }

//    /**
//     * @return Staff[] Returns an array of Staff objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Staff
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
