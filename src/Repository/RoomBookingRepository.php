<?php

namespace App\Repository;

use App\Entity\RoomBooking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RoomBooking>
 *
 * @method RoomBooking|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoomBooking|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoomBooking[]    findAll()
 * @method RoomBooking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoomBookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoomBooking::class);
    }

//    /**
//     * @return RoomBooking[] Returns an array of RoomBooking objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RoomBooking
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
