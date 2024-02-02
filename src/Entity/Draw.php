<?php

namespace App\Entity;

use App\Repository\DrawRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: DrawRepository::class)]
class Draw
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[Groups(['game:read-one'])]
    #[ORM\OneToMany(mappedBy: 'draw', targetEntity: Question::class)]
    private Collection $question;

    #[ORM\OneToMany(mappedBy: 'draw', targetEntity: ParticipantOfDraw::class)]
    private Collection $participantOfDraws;

    public function __construct()
    {
        $this->question = new ArrayCollection();
        $this->participantOfDraws = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestion(): Collection
    {
        return $this->question;
    }

    public function addQuestion(Question $question): static
    {
        if (!$this->question->contains($question)) {
            $this->question->add($question);
            $question->setDraw($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): static
    {
        if ($this->question->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getDraw() === $this) {
                $question->setDraw(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ParticipantOfDraw>
     */
    public function getParticipantOfDraws(): Collection
    {
        return $this->participantOfDraws;
    }

    public function addParticipantOfDraw(ParticipantOfDraw $participantOfDraw): static
    {
        if (!$this->participantOfDraws->contains($participantOfDraw)) {
            $this->participantOfDraws->add($participantOfDraw);
            $participantOfDraw->setDraw($this);
        }

        return $this;
    }

    public function removeParticipantOfDraw(ParticipantOfDraw $participantOfDraw): static
    {
        if ($this->participantOfDraws->removeElement($participantOfDraw)) {
            // set the owning side to null (unless already changed)
            if ($participantOfDraw->getDraw() === $this) {
                $participantOfDraw->setDraw(null);
            }
        }

        return $this;
    }
}
