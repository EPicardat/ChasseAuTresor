<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartiesRepository")
 */
class Parties
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_debut;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_fin;


    /**
     * @ORM\Column(type="boolean")
     */
    private $privee;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $latitude;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $longitude;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $message_fin;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PersonneRolePartie", mappedBy="Partie", orphanRemoval=true)
     */
    private $personneRoleParties;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PersonneReviewPartie", mappedBy="Partie")
     */
    private $personneReviewParties;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Indices", mappedBy="partie")
     */
    private $indices;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PersonneGpsPartie", mappedBy="Partie")
     */
    private $personneGpsParties;

    public function __construct()
    {
        $this->personneRoleParties = new ArrayCollection();
        $this->personneReviewParties = new ArrayCollection();
        $this->indices = new ArrayCollection();
        $this->personneGpsParties = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(?\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getPrivee(): ?bool
    {
        return $this->privee;
    }

    public function setPrivee(bool $privee): self
    {
        $this->privee = $privee;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getMessageFin(): ?string
    {
        return $this->message_fin;
    }

    public function setMessageFin(?string $message_fin): self
    {
        $this->message_fin = $message_fin;

        return $this;
    }

    /**
     * @return Collection|PersonneRolePartie[]
     */
    public function getPersonneRoleParties(): Collection
    {
        return $this->personneRoleParties;
    }

    public function addPersonneRoleParty(PersonneRolePartie $personneRoleParty): self
    {
        if (!$this->personneRoleParties->contains($personneRoleParty)) {
            $this->personneRoleParties[] = $personneRoleParty;
            $personneRoleParty->setPartie($this);
        }

        return $this;
    }

    public function removePersonneRoleParty(PersonneRolePartie $personneRoleParty): self
    {
        if ($this->personneRoleParties->contains($personneRoleParty)) {
            $this->personneRoleParties->removeElement($personneRoleParty);
            // set the owning side to null (unless already changed)
            if ($personneRoleParty->getPartie() === $this) {
                $personneRoleParty->setPartie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PersonneReviewPartie[]
     */
    public function getPersonneReviewParties(): Collection
    {
        return $this->personneReviewParties;
    }

    public function addPersonneReviewParty(PersonneReviewPartie $personneReviewParty): self
    {
        if (!$this->personneReviewParties->contains($personneReviewParty)) {
            $this->personneReviewParties[] = $personneReviewParty;
            $personneReviewParty->setPartie($this);
        }

        return $this;
    }

    public function removePersonneReviewParty(PersonneReviewPartie $personneReviewParty): self
    {
        if ($this->personneReviewParties->contains($personneReviewParty)) {
            $this->personneReviewParties->removeElement($personneReviewParty);
            // set the owning side to null (unless already changed)
            if ($personneReviewParty->getPartie() === $this) {
                $personneReviewParty->setPartie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Indices[]
     */
    public function getIndices(): Collection
    {
        return $this->indices;
    }

    public function addIndex(Indices $index): self
    {
        if (!$this->indices->contains($index)) {
            $this->indices[] = $index;
            $index->setPartie($this);
        }

        return $this;
    }

    public function removeIndex(Indices $index): self
    {
        if ($this->indices->contains($index)) {
            $this->indices->removeElement($index);
            // set the owning side to null (unless already changed)
            if ($index->getPartie() === $this) {
                $index->setPartie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PersonneGpsPartie[]
     */
    public function getPersonneGpsParties(): Collection
    {
        return $this->personneGpsParties;
    }

    public function addPersonneGpsParty(PersonneGpsPartie $personneGpsParty): self
    {
        if (!$this->personneGpsParties->contains($personneGpsParty)) {
            $this->personneGpsParties[] = $personneGpsParty;
            $personneGpsParty->setPartie($this);
        }

        return $this;
    }

    public function removePersonneGpsParty(PersonneGpsPartie $personneGpsParty): self
    {
        if ($this->personneGpsParties->contains($personneGpsParty)) {
            $this->personneGpsParties->removeElement($personneGpsParty);
            // set the owning side to null (unless already changed)
            if ($personneGpsParty->getPartie() === $this) {
                $personneGpsParty->setPartie(null);
            }
        }

        return $this;
    }
}
