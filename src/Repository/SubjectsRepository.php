<?php

namespace App\Repository;

use App\Entity\Subjects;
use App\Entity\SubjectsSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Subjects|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subjects|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subjects[]    findAll()
 * @method Subjects[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubjectsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subjects::class);
    }

    /**
     * @param SubjectsSearch $search
     * @return Query
     */
    public function findSujects(SubjectsSearch $search): Query
    {
        $query = $this->createQueryBuilder('s');

        if ($search->getSearchType()->count() > 0) {
            $k = 0;
            foreach ($search->getSearchType() as $k => $type) {
                $k++;
                $query = $query
                    ->orWhere("s.type IN (:type$k)")
                    ->setParameter("type$k", $type);
            }
        }
        return $query
            ->orderBy('s.createdAt', 'DESC')
            ->getQuery();
    }


    // /**
    //  * @return Subjects[] Returns an array of Subjects objects
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
    public function findOneBySomeField($value): ?Subjects
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
