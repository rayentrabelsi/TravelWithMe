<?php

namespace App\Entity;

use App\Repository\MoyTransportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: MoyTransportRepository::class)]
class MoyTransport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]

    #[ORM\Column]
    private ?int $id_transport = null;

    #[ORM\Column(length: 255)]
    private ?string $transport_model = null;

    #[ORM\Column]
    private ?int $transport_price = null;

    #[ORM\Column(length: 255)]
    private ?string $transport_description = null;

    #[ORM\Column(length: 255)]
    private ?string $disponibility = null;

    #[ORM\Column(length: 255)]
    private ?string $transport_picture = null;

    #[ORM\OneToMany(mappedBy: 'transport', targetEntity: Calendar::class)]
    private Collection $calendars;

    #[ORM\OneToMany(mappedBy: 'transport', targetEntity: Voyage::class)]
    private Collection $vehicule;

    public function __construct()
    {
        $this->calendars = new ArrayCollection();
    }

    public function getIdTransport(): ?int
    {
        return $this->id_transport;
    }

    public function setIdTransport(int $id_transport): static
    {
        $this->id_transport = $id_transport;

        return $this;
    }

    public function getTransportModel(): ?string
    {
        return $this->transport_model;
    }

    public function setTransportModel(string $transport_model): static
    {
        $this->transport_model = $transport_model;

        return $this;
    }

    public function getTransportPrice(): ?int
    {
        return $this->transport_price;
    }

    public function setTransportPrice(int $transport_price): static
    {
        $this->transport_price = $transport_price;

        return $this;
    }

    public function getTransportDescription(): ?string
    {
        return $this->transport_description;
    }

    public function setTransportDescription(string $transport_description): static
    {
        $this->transport_description = $transport_description;

        return $this;
    }

    public function getDisponibility(): ?string
    {
        return $this->disponibility;
    }

    public function setDisponibility(string $disponibility): static
    {
        $this->disponibility = $disponibility;

        return $this;
    }
    
    public function __toString()
    {
        return (string) $this->getTransportModel();
    }

    public function getTransportPicture(): ?string
    {
        return $this->transport_picture;
    }

    public function setTransportPicture(string $transport_picture): static
    {
        $this->transport_picture = $transport_picture;

        return $this;
    }

    /**
     * @return Collection<int, Calendar>
     */
    public function getCalendars(): Collection
    {
        return $this->calendars;
    }

    public function addCalendar(Calendar $calendar): static
    {
        if (!$this->calendars->contains($calendar)) {
            $this->calendars->add($calendar);
            $calendar->setTransport($this);
        }

        return $this;
    }

    public function removeCalendar(Calendar $calendar): static
    {
        if ($this->calendars->removeElement($calendar)) {
            // set the owning side to null (unless already changed)
            if ($calendar->getTransport() === $this) {
                $calendar->setTransport(null);
            }
        }

        return $this;
    }

     /**
     * @return Collection<int, Calendar>
     */
    public function getVehicule(): Collection
    {
        return $this->vehicule;
    }

    public function addVehicule(Voyage $Vehicule): static
    {
        if (!$this->vehicule->contains($Vehicule)) {
            $this->vehicule->add($Vehicule);
            $Vehicule->setVehicule($this);
        }

        return $this;
    }

    public function removeVehicule(Voyage $Vehicule): static
    {
        if ($this->calendars->removeElement($Vehicule)) {
            // set the owning side to null (unless already changed)
            if ($Vehicule->getVehicule() === $this) {
                $Vehicule->setVehicule(null);
            }
        }

        return $this;
    }

}
