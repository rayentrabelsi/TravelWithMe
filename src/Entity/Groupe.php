<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\GroupeRepository")]
class Groupe
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "integer")]
    private $utilisateurId;

    #[ORM\OneToOne(targetEntity: "App\Entity\Voyage", inversedBy: "groupe")]
    #[ORM\JoinColumn(name: "voyage_id", referencedColumnName: "id", onDelete: "CASCADE")]
    private $voyage; // Change the property name to just 'voyage'

    #[ORM\Column(type: "integer")]
    private $numberMembre;

    #[ORM\OneToOne(targetEntity: "App\Entity\User", inversedBy: "groupe")]
    #[ORM\JoinColumn(nullable: false)]
    private $utilisateur;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateurId(): ?int
    {
        return $this->utilisateurId;
    }

    public function setUtilisateurId(int $utilisateurId): self
    {
        $this->utilisateurId = $utilisateurId;

        return $this;
    }

    public function getVoyage(): ?Voyage // Adjust getter and setter methods accordingly
    {
        return $this->voyage;
    }

    public function setVoyage(?Voyage $voyage): self
    {
        $this->voyage = $voyage;

        return $this;
    }
    public function getnumberMembre(): ?int
    {
        return $this->numberMembre;
    }

    public function setnumberMembre(int $numberMembre): self
    {
        $this->numberMembre = $numberMembre;

        return $this;
    }

    
    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?User $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}