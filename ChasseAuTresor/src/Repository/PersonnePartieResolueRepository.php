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

    public function findPPR($id, $personne)
    {
        //On construit la requête via QueryBuilder
        $qb = $this->createQueryBuilder('a');
        $qb->where('a.Partie = :id');
        $qb->andWhere('a.Personne = :personne');

        $query=$qb->getQuery();

        // On injecte les paramètres dans la query
        $query->setParameter("id",$id);
        $query->setParameter("personne",$personne);

        // On récupère la réponse à la requête
        $result=$query->getOneOrNullResult();

        return $result;
    }
}
