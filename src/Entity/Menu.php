<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $entre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $plat = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dessert = null;

    #[ORM\Column]
    private ?int $id_resto = null;

    #[ORM\Column]
    private ?int $id_users = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntre(): ?string
    {
        return $this->entre;
    }

    public function setEntre(?string $entre): static
    {
        $this->entre = $entre;

        return $this;
    }

    public function getPlat(): ?string
    {
        return $this->plat;
    }

    public function setPlat(?string $plat): static
    {
        $this->plat = $plat;

        return $this;
    }

    public function getDessert(): ?string
    {
        return $this->dessert;
    }

    public function setDessert(?string $dessert): static
    {
        $this->dessert = $dessert;

        return $this;
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
}
