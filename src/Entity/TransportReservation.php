<?php

namespace App\Entity;

use App\Repository\TransportReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransportReservationRepository::class)]
class TransportReservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]

    #[ORM\Column]
    private ?int $id_reservation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $reservation_datetime = null;

    #[ORM\Column]
    private ?int $passenger_count = null;


    #[ORM\ManyToOne(inversedBy: 'transportReservations')]
    #[ORM\JoinColumn(name: 'customer_id', referencedColumnName: 'id_customer')]
    private ?User $customer = null;

    #[ORM\ManyToOne(inversedBy: 'transportReservations')]
    #[ORM\JoinColumn(name: 'transport_id', referencedColumnName: 'id_transport')]
    private ?MoyTransport $transport = null;


    public function getIdReservation(): ?int
    {
        return $this->id_reservation;
    }

    public function setIdReservation(int $id_reservation): static
    {
        $this->id_reservation = $id_reservation;

        return $this;
    }

    public function getReservationDatetime(): ?\DateTimeInterface
    {
        return $this->reservation_datetime;
    }

    public function setReservationDatetime(\DateTimeInterface $reservation_datetime): static
    {
        $this->reservation_datetime = $reservation_datetime;

        return $this;
    }

    public function getPassengerCount(): ?int
    {
        return $this->passenger_count;
    }

    public function setPassengerCount(int $passenger_count): static
    {
        $this->passenger_count = $passenger_count;

        return $this;
    }

    public function getCustomer(): ?User
    {
        return $this->customer;
    }

    public function setCustomer(?User $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getTransport(): ?MoyTransport
    {
        return $this->transport;
    }

    public function setTransport(?MoyTransport $transport): static
    {
        $this->transport = $transport;

        return $this;
    }
}
