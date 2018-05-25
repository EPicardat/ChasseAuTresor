<?php

namespace App\Repository;

use App\Entity\PersonnePartieResolue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PersonnePartieResolue|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonnePartieResolue|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonnePartieResolue[]    findAll()
 * @method PersonnePartieResolue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonnePartieResolueRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PersonnePartieResolue::class);
    }

//    /**
//     * @return PersonnePartieResolue[] Returns an array of PersonnePartieResolue objects
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
    public function findOneBySomeField($value): ?PersonnePartieResolue
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
