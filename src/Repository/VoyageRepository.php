<?php

namespace App\Repository;

use App\Entity\Voyage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Voyage>
 *
 * @method Voyage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Voyage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Voyage[]    findAll()
 * @method Voyage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoyageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Voyage::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Voyage $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Voyage $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Voyage[] Returns an array of Voyage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Voyage
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
     // Custom method to fetch voyages along with associated hebergement, vehicule, and evenement
     public function findAllWithDetails()
     {
         return $this->createQueryBuilder('v')
             ->select('v', 'v.id AS id', 'a.Lieu AS accomodationLieu', 've.transport_model AS vehiculeType', 'e.nom AS evenementNom', 'u.id AS userId')
             ->leftJoin('v.accomodation', 'a')
             ->leftJoin('v.vehicule', 've')
             ->leftJoin('v.evenement', 'e')
             ->leftJoin('v.utilisateur', 'u')
             ->getQuery()
             ->getResult();
     }
 
     public function findVoyageById($id): ?Voyage
     {
         return $this->createQueryBuilder('v')
             ->andWhere('v.id = :id')
             ->setParameter('id', $id)
             ->getQuery()
             ->getOneOrNullResult();
     }

public function findAll(): array
{
    return $this->createQueryBuilder('v')
        ->getQuery()
        ->getResult();
}


}
