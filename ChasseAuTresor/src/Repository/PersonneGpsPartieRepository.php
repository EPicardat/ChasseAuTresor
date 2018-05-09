<?php

namespace App\Repository;

use App\Entity\PersonneGpsPartie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PersonneGpsPartie|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonneGpsPartie|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonneGpsPartie[]    findAll()
 * @method PersonneGpsPartie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonneGpsPartieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PersonneGpsPartie::class);
    }

//    /**
//     * @return PersonneGpsPartie[] Returns an array of PersonneGpsPartie objects
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
    public function findOneBySomeField($value): ?PersonneGpsPartie
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
