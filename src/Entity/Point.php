<?php

namespace App\Entity;

use App\Repository\PointRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: PointRepository::class)]
class Point
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['game:read-one'])]
    #[ORM\Column]
    private ?int $point = null;

    #[ORM\OneToOne(inversedBy: 'point', cascade: ['persist', 'remove'])]
    private ?Participant $username = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoint(): ?int
    {
        return $this->point;
    }

    public function setPoint(int $point): static
    {
        $this->point = $point;

        return $this;
    }

    public function getUsername(): ?Participant
    {
        return $this->username;
    }

    public function setUsername(?Participant $username): static
    {
        $this->username = $username;

        return $this;
    }
}
