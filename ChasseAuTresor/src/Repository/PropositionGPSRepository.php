<?php

namespace App\Repository;

use App\Entity\PropositionGPS;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PropositionGPS|null find($id, $lockMode = null, $lockVersion = null)
 * @method PropositionGPS|null findOneBy(array $criteria, array $orderBy = null)
 * @method PropositionGPS[]    findAll()
 * @method PropositionGPS[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropositionGPSRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PropositionGPS::class);
    }

//    /**
//     * @return PropositionGPS[] Returns an array of PropositionGPS objects
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
    public function findOneBySomeField($value): ?PropositionGPS
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
