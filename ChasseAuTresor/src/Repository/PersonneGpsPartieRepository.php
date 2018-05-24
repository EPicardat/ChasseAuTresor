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

    // Cette fonction compte le nombre de propositions GPS déjà soumise(s) et enregistrée(s) dans la BDD

    /**
     * @param $id
     * @param $who
     * @return int
     */
    public function countProposition($id, $who)
    {
        //On construit requête via QueryBuilder
        $qb = $this->createQueryBuilder('a');
        $qb->select($qb->expr()->count('a'));
        $qb->where('a.id = :id');
        $qb->andWhere('a.Personne = :who');
        $query=$qb->getQuery();

        // On injecte les paramètres $id et $who dans la query
        $query->setParameter("id",'%'.$id.'%');
        $query->setParameter("who",'%'.$who.'%');

        // On récupère la réponse à la requête
        $result=$query->getResult();

        return $result;

    }
}
