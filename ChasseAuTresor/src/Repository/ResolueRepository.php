<?php

namespace App\Repository;

use App\Entity\Resolue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Resolue|null find($id, $lockMode = null, $lockVersion = null)
 * @method Resolue|null findOneBy(array $criteria, array $orderBy = null)
 * @method Resolue[]    findAll()
 * @method Resolue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResolueRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Resolue::class);
    }

//    /**
//     * @return Resolue[] Returns an array of Resolue objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Resolue
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
