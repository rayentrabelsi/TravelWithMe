<?php

namespace App\Entity;

use App\Repository\MoyTransportRepository;
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

    #[ORM\OneToMany(mappedBy: 'transport', targetEntity: TransportReservation::class)]
    private Collection $transportReservations;

    #[ORM\Column(length: 255)]
    private ?string $transport_picture = null;

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

    public function getTransportPicture(): ?string
    {
        return $this->transport_picture;
    }

    public function setTransportPicture(string $transport_picture): static
    {
        $this->transport_picture = $transport_picture;

        return $this;
    }

}
