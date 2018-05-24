<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResolueRepository")
 */
class Resolue
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Resolue;

    public function getId()
    {
        return $this->id;
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
}
