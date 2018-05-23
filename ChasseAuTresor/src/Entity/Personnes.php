<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonnesRepository")
 */
class Personnes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_inscription;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PersonneRolePartie", mappedBy="PersonneId")
     */
    private $personneRoleParties;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PersonneReviewPartie", mappedBy="Personne")
     */
    private $personneReviewParties;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PersonneGpsPartie", mappedBy="Personne")
     */
    private $personneGpsParties;

    public function __construct()
    {
        $this->personneRoleParties = new ArrayCollection();
        $this->personneReviewParties = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->date_inscription;
    }

    public function setDateInscription(\DateTimeInterface $date_inscription): self
    {
        $this->date_inscription = $date_inscription;

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
            $personneRoleParty->setPersonne($this);
        }

        return $this;
    }

    public function removePersonneRoleParty(PersonneRolePartie $personneRoleParty): self
    {
        if ($this->personneRoleParties->contains($personneRoleParty)) {
            $this->personneRoleParties->removeElement($personneRoleParty);
            // set the owning side to null (unless already changed)
            if ($personneRoleParty->getPersonne() === $this) {
                $personneRoleParty->setPersonne(null);
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
            $personneReviewParty->setPersonne($this);
        }

        return $this;
    }

    public function removePersonneReviewParty(PersonneReviewPartie $personneReviewParty): self
    {
        if ($this->personneReviewParties->contains($personneReviewParty)) {
            $this->personneReviewParties->removeElement($personneReviewParty);
            // set the owning side to null (unless already changed)
            if ($personneReviewParty->getPersonne() === $this) {
                $personneReviewParty->setPersonne(null);
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
            $personneGpsParty->setPersonne($this);
        }

        return $this;
    }

    public function removePersonneGpsParty(PersonneGpsPartie $personneGpsParty): self
    {
        if ($this->personneGpsParties->contains($personneGpsParty)) {
            $this->personneGpsParties->removeElement($personneGpsParty);
            // set the owning side to null (unless already changed)
            if ($personneGpsParty->getPersonne() === $this) {
                $personneGpsParty->setPersonne(null);
            }
        }

        return $this;
    }
<<<<<<< Updated upstream
=======

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->pseudo,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->pseudo,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized, ['allowed_classes' => false]);
    }

    public function getRoles()
    {
        return array("ROLE_USER");
    }

    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->pseudo;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
>>>>>>> Stashed changes
}
