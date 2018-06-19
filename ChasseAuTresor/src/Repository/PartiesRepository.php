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

    public function findGameList()
   {
       //On construit requête via QueryBuilder
       $qb = $this->createQueryBuilder('a');
       $qb->select('a.id');
       $qb->addSelect('a.nom');
       $qb->addSelect('a.photo');

       $query=$qb->getQuery();

       $result=$query->getArrayResult();

       return $result;
   }

    public function findBasic($id)
    {
        //On construit requête via QueryBuilder
        $qb = $this->createQueryBuilder('a');
        $qb->select('a.nom');
        $qb->addSelect('a.dateDebut');
        $qb->addSelect('a.dateFin');
        $qb->addSelect('a.photo');
        $qb->where('a.id = :id');
        $query=$qb->getQuery();

        // On injecte le paramètre $id dans la query
        $query->setParameter("id",'%'.$id.'%');

        // On récupère la réponse à la requête
        // getArrayResult() est plus rapide que getResult dans le cas d'un simple lecture
        $result=$query->getArrayResult();

        return $result;
    }

    /**
     * @param $id
     * @return array
     */
    public function findSuccessMessage($id)
    {
        //On construit requête via QueryBuilder
        $qb = $this->createQueryBuilder('a');
        $qb->select('a.messageFin');
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
