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
     * @ORM\OneToMany(targetEntity="App\Entity\Personnes", mappedBy="personnePartieResolue")
     */
    private $Personne_id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Parties", mappedBy="personnePartieResolue")
     */
    private $Partie_Id;

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
        $this->Personne_id = new ArrayCollection();
        $this->Partie_Id = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Collection|Personnes[]
     */
    public function getPersonneId(): Collection
    {
        return $this->Personne_id;
    }

    public function addPersonneId(Personnes $personneId): self
    {
        if (!$this->Personne_id->contains($personneId)) {
            $this->Personne_id[] = $personneId;
            $personneId->setPersonnePartieResolue($this);
        }

        return $this;
    }

    public function removePersonneId(Personnes $personneId): self
    {
        if ($this->Personne_id->contains($personneId)) {
            $this->Personne_id->removeElement($personneId);
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
    public function getPartieId(): Collection
    {
        return $this->Partie_Id;
    }

    public function addPartieId(Parties $partieId): self
    {
        if (!$this->Partie_Id->contains($partieId)) {
            $this->Partie_Id[] = $partieId;
            $partieId->setPersonnePartieResolue($this);
        }

        return $this;
    }

    public function removePartieId(Parties $partieId): self
    {
        if ($this->Partie_Id->contains($partieId)) {
            $this->Partie_Id->removeElement($partieId);
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
