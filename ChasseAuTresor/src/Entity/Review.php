<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReviewRepository")
 */
class Review
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $note;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $review;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PersonneReviewPartie", mappedBy="Review")
     */
    private $personneReviewParties;

    public function __construct()
    {
        $this->personneReviewParties = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getReview(): ?string
    {
        return $this->review;
    }

    public function setReview(?string $review): self
    {
        $this->review = $review;

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
            $personneReviewParty->setReview($this);
        }

        return $this;
    }

    public function removePersonneReviewParty(PersonneReviewPartie $personneReviewParty): self
    {
        if ($this->personneReviewParties->contains($personneReviewParty)) {
            $this->personneReviewParties->removeElement($personneReviewParty);
            // set the owning side to null (unless already changed)
            if ($personneReviewParty->getReview() === $this) {
                $personneReviewParty->setReview(null);
            }
        }

        return $this;
    }
}
