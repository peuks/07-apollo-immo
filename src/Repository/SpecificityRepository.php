<?php

namespace App\Repository;

use App\Entity\Specificity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Specificity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Specificity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Specificity[]    findAll()
 * @method Specificity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecificityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Specificity::class);
    }

    // /**
    //  * @return Specificity[] Returns an array of Specificity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Specificity
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
