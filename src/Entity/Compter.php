<?php

namespace App\Entity;

use App\Repository\CompterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompterRepository::class)]
class Compter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $compteur = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isResponseVisible = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isExplicationVisible = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompteur(): ?int
    {
        return $this->compteur;
    }

    public function setCompteur(int $compteur): static
    {
        $this->compteur = $compteur;

        return $this;
    }

    public function isIsResponseVisible(): ?bool
    {
        return $this->isResponseVisible;
    }

    public function setIsResponseVisible(?bool $isResponseVisible): static
    {
        $this->isResponseVisible = $isResponseVisible;

        return $this;
    }

    public function isIsExplicationVisible(): ?bool
    {
        return $this->isExplicationVisible;
    }

    public function setIsExplicationVisible(?bool $isExplicationVisible): static
    {
        $this->isExplicationVisible = $isExplicationVisible;

        return $this;
    }


}
