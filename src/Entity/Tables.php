<?php

namespace App\Entity;

use App\Repository\TablesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TablesRepository::class)]
#[ORM\Table(name: 'seats')]
class Tables
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'tables', cascade: ['persist', 'remove'])]
    private ?Bookings $reservation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReservation(): ?bookings
    {
        return $this->reservation;
    }

    public function setReservation(?bookings $reservation): static
    {
        $this->reservation = $reservation;

        return $this;
    }
}
