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

}
