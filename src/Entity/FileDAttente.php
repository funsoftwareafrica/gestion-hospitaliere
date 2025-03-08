<?php

namespace App\Entity;

use App\Repository\FileDAttenteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FileDAttenteRepository::class)]
class FileDAttente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: Urgence::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    private ?Urgence $urgence = null;

    #[ORM\Column]
    #[Assert\Positive]
    private ?int $position = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrgence(): ?Urgence
    {
        return $this->urgence;
    }

    public function setUrgence(Urgence $urgence): static
    {
        $this->urgence = $urgence;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }
}
