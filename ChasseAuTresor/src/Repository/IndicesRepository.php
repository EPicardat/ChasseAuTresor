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

    public function getClue1($id)
    {
       //TODO
    }

    public function getClue2($id)
    {
        //TODO
    }

}
