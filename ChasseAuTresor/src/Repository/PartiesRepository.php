<?php

namespace App\Repository;

use App\Entity\Parties;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Parties|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parties|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parties[]    findAll()
 * @method Parties[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartiesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Parties::class);
    }

//    /**
//     * @return Parties[] Returns an array of Parties objects
//     */
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
    public function findOneBySomeField($value): ?Parties
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
