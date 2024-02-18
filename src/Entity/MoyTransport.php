<?php

namespace App\Entity;

use App\Repository\MoyTransportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MoyTransportRepository::class)]
class MoyTransport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]

    #[ORM\Column]
    private ?int $id_transport = null;

    #[ORM\Column(length: 255)]
    private ?string $transport_type = null;

    #[ORM\Column(length: 255)]
    private ?string $departure_point = null;

    #[ORM\Column(length: 255)]
    private ?string $arrival_point = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\OneToMany(mappedBy: 'transport', targetEntity: TransportReservation::class)]
    private Collection $transportReservations;

    public function __construct()
    {
        $this->transportReservations = new ArrayCollection();
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

    public function getTransportType(): ?string
    {
        return $this->transport_type;
    }

    public function setTransportType(string $transport_type): static
    {
        $this->transport_type = $transport_type;

        return $this;
    }

    public function getDeparturePoint(): ?string
    {
        return $this->departure_point;
    }

    public function setDeparturePoint(string $departure_point): static
    {
        $this->departure_point = $departure_point;

        return $this;
    }

    public function getArrivalPoint(): ?string
    {
        return $this->arrival_point;
    }

    public function setArrivalPoint(string $arrival_point): static
    {
        $this->arrival_point = $arrival_point;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, TransportReservation>
     */
    public function getTransportReservations(): Collection
    {
        return $this->transportReservations;
    }

    public function addTransportReservation(TransportReservation $transportReservation): static
    {
        if (!$this->transportReservations->contains($transportReservation)) {
            $this->transportReservations->add($transportReservation);
            $transportReservation->setTransport($this);
        }

        return $this;
    }

    public function removeTransportReservation(TransportReservation $transportReservation): static
    {
        if ($this->transportReservations->removeElement($transportReservation)) {
            // set the owning side to null (unless already changed)
            if ($transportReservation->getTransport() === $this) {
                $transportReservation->setTransport(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getIdTransport();
    }
}
