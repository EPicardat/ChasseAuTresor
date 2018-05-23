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

    // Cette fonction compte le nombre de propositions GPS déjà soumises et enregistrées dans la BDD
    public function countProposition($id,$who)
    {
        //TODO

        $nbProposition=0;
        return $nbProposition;
    }
}
