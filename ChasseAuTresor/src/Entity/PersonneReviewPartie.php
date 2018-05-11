<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonneReviewPartieRepository")
 */
class PersonneReviewPartie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Personnes", inversedBy="personneReviewParties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Personne;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Review", inversedBy="personneReviewParties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Review;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parties", inversedBy="personneReviewParties")
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

    public function getReview(): ?Review
    {
        return $this->Review;
    }

    public function setReview(?Review $Review): self
    {
        $this->Review = $Review;

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
