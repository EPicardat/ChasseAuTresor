<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IndicesRepository")
 */
class Indices
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $indice;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeIndice", inversedBy="indices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $TypeIndice;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parties", inversedBy="indices")
     * @ORM\JoinColumn(nullable=true)
     */
    private $partie;

    public function getId()
    {
        return $this->id;
    }

    public function getIndice(): ?string
    {
        return $this->indice;
    }

    public function setIndice(string $indice): self
    {
        $this->indice = $indice;

        return $this;
    }

    public function getTypeIndice(): ?TypeIndice
    {
        return $this->TypeIndice;
    }

    public function setTypeIndice(?TypeIndice $TypeIndice): self
    {
        $this->TypeIndice = $TypeIndice;

        return $this;
    }

    public function getPartie(): ?Parties
    {
        return $this->partie;
    }

    public function setPartie(?Parties $partie): self
    {
        $this->partie = $partie;

        return $this;
    }
}
