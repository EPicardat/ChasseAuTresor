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

    public function getClues($id)
    {
        //On construit requête via QueryBuilder
        $qb = $this->createQueryBuilder('a');
        $qb->select('a.indice');
        $qb->where('a.id = :id');
        $query=$qb->getQuery();

        // On injecte le paramètre $id dans la query
        $query->setParameter("id",'%'.$id.'%');

        // On récupère la réponse à la requête
        // getArrayResult() est plus rapide que getResult dans le cas d'un simple lecture
        $result=$query->getArrayResult();

        return $result;
    }

}
