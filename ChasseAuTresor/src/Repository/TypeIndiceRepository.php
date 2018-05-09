<?php

namespace App\Repository;

use App\Entity\TypeIndice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypeIndice|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeIndice|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeIndice[]    findAll()
 * @method TypeIndice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeIndiceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TypeIndice::class);
    }

//    /**
//     * @return TypeIndice[] Returns an array of TypeIndice objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeIndice
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
