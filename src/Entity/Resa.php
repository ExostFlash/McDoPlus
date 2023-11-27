<?php

namespace App\Entity;

use App\Repository\ResaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResaRepository::class)]
class Resa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_resto = null;

    #[ORM\Column]
    private ?int $nb_user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_heur = null;

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

    public function getNbUser(): ?int
    {
        return $this->nb_user;
    }

    public function setNbUser(int $nb_user): static
    {
        $this->nb_user = $nb_user;

        return $this;
    }

    public function getDateHeur(): ?\DateTimeInterface
    {
        return $this->date_heur;
    }

    public function setDateHeur(\DateTimeInterface $date_heur): static
    {
        $this->date_heur = $date_heur;

        return $this;
    }
}
