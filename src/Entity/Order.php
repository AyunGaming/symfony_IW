<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tables $seat = null;

    #[ORM\Column(enumType: OrderStatus::class)]
    private ?OrderStatus $status = OrderStatus::NEW;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeat(): ?Tables
    {
        return $this->seat;
    }

    public function setSeat(Tables $seat): static
    {
        $this->seat = $seat;

        return $this;
    }

    public function getStatus(): ?OrderStatus
    {
        return $this->status;
    }

    public function setStatus(OrderStatus $status): static
    {
        $this->status = $status;

        return $this;
    }
}
