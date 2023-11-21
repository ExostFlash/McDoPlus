<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_resto = null;

    #[ORM\Column]
    private ?int $id_users = null;

    #[ORM\Column(length: 50)]
    private ?string $payement = null;

    #[ORM\Column]
    private ?int $id_menu = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdResto(): ?int
    {
        return $this->id_resto;
    }

    public function setIdResto(int $id_resto): static
    {
        $this->id_resto = $id_resto;

        return $this;
    }

    public function getIdUsers(): ?int
    {
        return $this->id_users;
    }

    public function setIdUsers(int $id_users): static
    {
        $this->id_users = $id_users;

        return $this;
    }

    public function getPayement(): ?string
    {
        return $this->payement;
    }

    public function setPayement(string $payement): static
    {
        $this->payement = $payement;

        return $this;
    }

    public function getIdMenu(): ?int
    {
        return $this->id_menu;
    }

    public function setIdMenu(int $id_menu): static
    {
        $this->id_menu = $id_menu;

        return $this;
    }
}
