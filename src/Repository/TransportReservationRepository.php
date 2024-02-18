<?php

namespace App\Repository;

use App\Entity\TransportReservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TransportReservation>
 *
 * @method TransportReservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method TransportReservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method TransportReservation[]    findAll()
 * @method TransportReservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransportReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TransportReservation::class);
    }

//    /**
//     * @return TransportReservation[] Returns an array of TransportReservation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TransportReservation
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
