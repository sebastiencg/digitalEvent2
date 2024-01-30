<?php

namespace App\Entity;

use App\Repository\PartyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartyRepository::class)]
class Party
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Question::class, inversedBy: 'parties')]
    private Collection $Question;

    #[ORM\OneToMany(mappedBy: 'party', targetEntity: Participant::class)]
    private Collection $participant;

    public function __construct()
    {
        $this->Question = new ArrayCollection();
        $this->participant = new ArrayCollection();
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
        return $this->Question;
    }

    public function addQuestion(Question $question): static
    {
        if (!$this->Question->contains($question)) {
            $this->Question->add($question);
        }

        return $this;
    }

    public function removeQuestion(Question $question): static
    {
        $this->Question->removeElement($question);

        return $this;
    }

    /**
     * @return Collection<int, Participant>
     */
    public function getParticipant(): Collection
    {
        return $this->participant;
    }

    public function addParticipant(Participant $participant): static
    {
        if (!$this->participant->contains($participant)) {
            $this->participant->add($participant);
            $participant->setParty($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): static
    {
        if ($this->participant->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getParty() === $this) {
                $participant->setParty(null);
            }
        }

        return $this;
    }
}
