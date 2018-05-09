<?php

namespace App\Repository;

use App\Entity\Indices;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Indices|null find($id, $lockMode = null, $lockVersion = null)
 * @method Indices|null findOneBy(array $criteria, array $orderBy = null)
 * @method Indices[]    findAll()
 * @method Indices[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IndicesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Indices::class);
    }

//    /**
//     * @return Indices[] Returns an array of Indices objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Indices
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
