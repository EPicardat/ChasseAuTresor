<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeIndiceRepository")
 */
class TypeIndice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Indices", mappedBy="TypeIndice")
     */
    private $indices;

    public function __construct()
    {
        $this->indices = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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
            $index->setTypeIndice($this);
        }

        return $this;
    }

    public function removeIndex(Indices $index): self
    {
        if ($this->indices->contains($index)) {
            $this->indices->removeElement($index);
            // set the owning side to null (unless already changed)
            if ($index->getTypeIndice() === $this) {
                $index->setTypeIndice(null);
            }
        }

        return $this;
    }
}
