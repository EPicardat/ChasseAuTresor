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
}
