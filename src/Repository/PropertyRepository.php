<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    /**
     * @method  findAllAvailable("true"|"false")
     * 
     * Will find all available or sold properties
     * 
     * @method  findAllAvailable("true") will return all solded properties
     *  
     * @method  findAllAvailable("false") will return all availables properties 
     * @return Query
     */

    public function findAllAvailableQuery($sold = "false", $order = "ASC"): Query
    {
        // QueryBuilder('p') is a an objcet that let us construct ( concevoir ) a query with an alias 'p'
        return $this->findVisibleQuery($sold, $order)
            // Check every Property still avaible ( not sold ) 
            ->getQuery();

        // On veut que la requeête pour la pagination
        // ->getResult();
    }


    /**
     * @method  findLatest($sold = "true|false", $maxResult = 5, $order = "DESC|ASC")
     *  Will find x latest sold/available properties
     *  By default will return the $maxResult = 5 latests availables ($sold = "false"), properties by DESC order
     */

    public function findLatest($sold = "false", $maxResult = 5, $order = "DESC"): array
    {
        // QueryBuilder('p') is a an objcet that let us construct ( concevoir ) a query with an alias 'p'
        return $this->findVisibleQuery($sold, $order)
            ->setMaxResults($maxResult)
            ->getQuery()
            ->getResult();
    }

    /*
     * @method  findVisibleQuery($sold="false",$order="ASC")
     * will return all solded ($sold=true)| available ($sold=false) properties by order  $order = ASC | DESC 
     * 
     */

    private function findVisibleQuery($sold, $order): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->where("p.sold = $sold")
            ->orderBy('p.id', "$order");
    }
    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
