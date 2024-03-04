<?php

// src/Entity/Event.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: "App\Repository\EventRepository")]
class Event
{
    #[ORM\Id, ORM\GeneratedValue(strategy: "AUTO"), ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "string")]
    private $nom;

    #[ORM\Column(type: "text")]
    private $description;

    #[ORM\OneToMany(targetEntity: "App\Entity\Voyage", mappedBy: "evenement")]
    private $voyages;

    public function __construct()
    {
        $this->voyages = new ArrayCollection();
    }


    // Getters and setters
    public function getId(): ?int
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
     /**
     * @return Collection|Voyage[]
     */
    public function getVoyages(): Collection
    {
        return $this->voyages;
    }

    public function addVoyage(Voyage $voyage): self
    {
        if (!$this->voyages->contains($voyage)) {
            $this->voyages[] = $voyage;
            $voyage->setEvenement($this);
        }

        return $this;
    }

    public function removeVoyage(Voyage $voyage): self
    {
        if ($this->voyages->removeElement($voyage)) {
            // set the owning side to null (unless already changed)
            if ($voyage->getEvenement() === $this) {
                $voyage->setEvenement(null);
            }
        }

        return $this;
    }
}
