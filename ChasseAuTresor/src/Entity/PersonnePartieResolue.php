<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonnePartieResolueRepository")
 */
class PersonnePartieResolue
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Personnes", inversedBy="personnePartieResolues")
     */
    private $Personne;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parties", inversedBy="personnePartieResolues")
     */
    private $Partie;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Resolue;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Role;

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

    public function getPartie(): ?Parties
    {
        return $this->Partie;
    }

    public function setPartie(?Parties $Partie): self
    {
        $this->Partie = $Partie;

        return $this;
    }

    public function getResolue(): ?bool
    {
        return $this->Resolue;
    }

    public function setResolue(bool $Resolue): self
    {
        $this->Resolue = $Resolue;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->Role;
    }

    public function setRole(string $Role): self
    {
        $this->Role = $Role;

        return $this;
    }
}
