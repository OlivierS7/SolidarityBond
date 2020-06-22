<?php

namespace App\Repository;

use App\Entity\SubjectsSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SubjectsSearch|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubjectsSearch|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubjectsSearch[]    findAll()
 * @method SubjectsSearch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubjectsSearchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubjectsSearch::class);
    }

    // /**
    //  * @return SubjectsSearch[] Returns an array of SubjectsSearch objects
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
    public function findOneBySomeField($value): ?SubjectsSearch
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
