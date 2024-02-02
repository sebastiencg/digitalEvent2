<?php

namespace App\Entity;

use App\Repository\ParticipantOfDrawRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ParticipantOfDrawRepository::class)]
class ParticipantOfDraw
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['game:read-one'])]
    #[ORM\OneToMany(mappedBy: 'participantOfDraw', targetEntity: Participant::class)]
    private Collection $participantOfDraw;

    #[Groups(['game:read-one'])]
    #[ORM\ManyToOne(inversedBy: 'participantOfDraws')]
    private ?Draw $draw = null;

    public function __construct()
    {
        $this->participantOfDraw = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Participant>
     */
    public function getParticipantOfDraw(): Collection
    {
        return $this->participantOfDraw;
    }

    public function addParticipantOfDraw(Participant $participantOfDraw): static
    {
        if (!$this->participantOfDraw->contains($participantOfDraw)) {
            $this->participantOfDraw->add($participantOfDraw);
            $participantOfDraw->setParticipantOfDraw($this);
        }

        return $this;
    }

    public function removeParticipantOfDraw(Participant $participantOfDraw): static
    {
        if ($this->participantOfDraw->removeElement($participantOfDraw)) {
            // set the owning side to null (unless already changed)
            if ($participantOfDraw->getParticipantOfDraw() === $this) {
                $participantOfDraw->setParticipantOfDraw(null);
            }
        }

        return $this;
    }

    public function getDraw(): ?Draw
    {
        return $this->draw;
    }

    public function setDraw(?Draw $draw): static
    {
        $this->draw = $draw;

        return $this;
    }
}
