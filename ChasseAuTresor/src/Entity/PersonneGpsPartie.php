<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonneGpsPartieRepository")
 */
class PersonneGpsPartie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Personnes", inversedBy="personneGpsParties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Personne;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PropositionGPS")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Gps;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parties", inversedBy="personneGpsParties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Partie;

    public function getId()
    {
        return $this->id;
    }

    public function getPersonne(): ?Personnes
    {
        return $this->Personne;
    }

    public function setPersonne(?Personnes $Personne): self
    {
        $this->Personne = $Personne;

        return $this;
    }

    public function getGps(): ?PropositionGPS
    {
        return $this->Gps;
    }

    public function setGps(?PropositionGPS $Gps): self
    {
        $this->Gps = $Gps;

        return $this;
    }

    public function getPartie(): ?Parties
    {
        return $this->Partie;
    }

    public function setPartie(?Parties $Partie): self
    {
        $this->Partie = $Partie;

        return $this;
    }
}
