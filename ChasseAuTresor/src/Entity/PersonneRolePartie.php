<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonneRolePartieRepository")
 */
class PersonneRolePartie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Personnes", inversedBy="personneRoleParties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Personne;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\role")
     * @ORM\JoinColumn(nullable=false)
     */
    private $role;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parties", inversedBy="personneRoleParties")
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

    public function getRole(): ?role
    {
        return $this->role;
    }

    public function setRole(?role $role): self
    {
        $this->role = $role;

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
