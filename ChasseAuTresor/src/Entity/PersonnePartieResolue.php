<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Personnes")
     */
    private $Personne;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parties")
     */
    private $Partie;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Resolue;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $Role;

    public function __construct()
    {
        $this->Personne = new ArrayCollection();
        $this->Partie = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Collection|Personnes[]
     */
    public function getPersonne(): Collection
    {
        return $this->Personne;
    }

    public function addPersonneId(Personnes $personneId): self
    {
        if (!$this->Personne->contains($personneId)) {
            $this->Personne[] = $personneId;
            $personneId->setPersonnePartieResolue($this);
        }

        return $this;
    }

    public function removePersonneId(Personnes $personneId): self
    {
        if ($this->Personne->contains($personneId)) {
            $this->Personne->removeElement($personneId);
            // set the owning side to null (unless already changed)
            if ($personneId->getPersonnePartieResolue() === $this) {
                $personneId->setPersonnePartieResolue(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Parties[]
     */
    public function getPartie(): Collection
    {
        return $this->Partie;
    }

    public function addPartieId(Parties $partieId): self
    {
        if (!$this->Partie->contains($partieId)) {
            $this->Partie[] = $partieId;
            $partieId->setPersonnePartieResolue($this);
        }

        return $this;
    }

    public function removePartieId(Parties $partieId): self
    {
        if ($this->Partie->contains($partieId)) {
            $this->Partie->removeElement($partieId);
            // set the owning side to null (unless already changed)
            if ($partieId->getPersonnePartieResolue() === $this) {
                $partieId->setPersonnePartieResolue(null);
            }
        }

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
