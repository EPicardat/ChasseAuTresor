<?php

namespace App\Repository;

use App\Entity\PersonneReviewPartie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PersonneReviewPartie|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonneReviewPartie|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonneReviewPartie[]    findAll()
 * @method PersonneReviewPartie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonneReviewPartieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PersonneReviewPartie::class);
    }

//    /**
//     * @return PersonneReviewPartie[] Returns an array of PersonneReviewPartie objects
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
    public function findOneBySomeField($value): ?PersonneReviewPartie
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
