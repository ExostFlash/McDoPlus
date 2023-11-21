<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $note = null;

    #[ORM\Column(length: 255)]
    private ?string $com = null;

    #[ORM\Column]
    private ?int $id_ticket = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getCom(): ?string
    {
        return $this->com;
    }

    public function setCom(string $com): static
    {
        $this->com = $com;

        return $this;
    }

    public function getIdTicket(): ?int
    {
        return $this->id_ticket;
    }

    public function setIdTicket(int $id_ticket): static
    {
        $this->id_ticket = $id_ticket;

        return $this;
    }
}
