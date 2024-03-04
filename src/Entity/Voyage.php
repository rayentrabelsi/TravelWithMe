<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use DateTime; // Import the DateTime class


#[ORM\Entity(repositoryClass: "App\Repository\VoyageRepository")]
class Voyage
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "integer")]
    private $vehiculeId;

    #[ORM\Column(type: "integer")]
    private $evenementId;

    #[ORM\Column(type: "integer")]
    private $accomodationId;

    #[ORM\Column(type: "date")]
    private $depart;

    #[ORM\Column(type: "date")]
    private $arrivee;
    
    #[ORM\Column(name: "utilisateur_id", type: "integer")]
    private $utilisateurId;

    #[ORM\OneToOne(targetEntity: "App\Entity\Groupe", mappedBy: "voyage")]
    private $groupe;

    #[ORM\ManyToOne(targetEntity: "App\Entity\MoyTransport", inversedBy: "voyages")]
    #[ORM\JoinColumn(name: "vehicule_id", referencedColumnName: "id_transport")]
    private $vehicule;

    #[ORM\ManyToOne(targetEntity: "App\Entity\Event", inversedBy: "voyages")]
    #[ORM\JoinColumn(name: "evenement_id", referencedColumnName: "id")]
    private $evenement;

    #[ORM\OneToOne(targetEntity: "App\Entity\User", inversedBy: "voyage")]
    #[ORM\JoinColumn(nullable: false)]
    private $utilisateur;

    #[ORM\ManyToOne(inversedBy: 'voyages')]
    #[ORM\JoinColumn(name: "accomodation_id", referencedColumnName: "id")]
    private ?Accomodation $accomodation = null;

  
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVehiculeId(): ?int
    {
        return $this->vehiculeId;
    }

    public function setVehiculeId(int $vehiculeId): self
    {
        $this->vehiculeId = $vehiculeId;

        return $this;
    }

    public function getaccomodationId(): ?int
    {
        return $this->accomodationId;
    }

    public function setaccomodationId(int $accomodationId): self
    {
        $this->accomodationId = $accomodationId;

        return $this;
    }

    public function getEvenementId(): ?int
    {
        return $this->evenementId;
    }

    public function setEvenementId(int $evenementId): self
    {
        $this->evenementId = $evenementId;

        return $this;
    }

    public function getDepart(): ?\DateTimeInterface
    {
        return $this->depart;
    }

    public function setDepart(\DateTimeInterface $depart): self
    {
        $this->depart = $depart;

        return $this;
    }

    public function getArrivee(): ?\DateTimeInterface
    {
        return $this->arrivee;
    }

    public function setArrivee(\DateTimeInterface $arrivee): self
    {
        $this->arrivee = $arrivee;

        return $this;
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

    public function getVehicule(): ?MoyTransport
    {
        return $this->vehicule;
    }

    public function setVehicule(?MoyTransport $vehicule): self
    {
        $this->vehicule = $vehicule;

        return $this;
    }

    public function getEvenement(): ?Event
    {
        return $this->evenement;
    }

    public function setEvenement(?Event $evenement): self
    {
        $this->evenement = $evenement;

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

    public function getAccomodation(): ?Accomodation
    {
        return $this->accomodation;
    }

    public function setAccomodation(?Accomodation $accomodation): static
    {
        $this->accomodation = $accomodation;

        return $this;
    }
}