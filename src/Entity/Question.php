<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $question = null;




    #[ORM\OneToMany(mappedBy: 'response', targetEntity: ResponseOfQuestion::class, orphanRemoval: true)]
    private Collection $responses;

    #[ORM\Column]
    private ?int $point = null;

    #[ORM\ManyToMany(targetEntity: Party::class, mappedBy: 'Question')]
    private Collection $parties;

    public function __construct()
    {
        $this->responses = new ArrayCollection();
        $this->parties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): static
    {
        $this->question = $question;

        return $this;
    }



    /**
     * @return Collection<int, ResponseOfQuestion>
     */
    public function getResponses(): Collection
    {
        return $this->responses;
    }

    public function addResponse(ResponseOfQuestion $response): static
    {
        if (!$this->responses->contains($response)) {
            $this->responses->add($response);
            $response->setResponse($this);
        }

        return $this;
    }

    public function removeResponse(ResponseOfQuestion $response): static
    {
        if ($this->responses->removeElement($response)) {
            // set the owning side to null (unless already changed)
            if ($response->getResponse() === $this) {
                $response->setResponse(null);
            }
        }

        return $this;
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

    /**
     * @return Collection<int, Party>
     */
    public function getParties(): Collection
    {
        return $this->parties;
    }

    public function addParty(Party $party): static
    {
        if (!$this->parties->contains($party)) {
            $this->parties->add($party);
            $party->addQuestion($this);
        }

        return $this;
    }

    public function removeParty(Party $party): static
    {
        if ($this->parties->removeElement($party)) {
            $party->removeQuestion($this);
        }

        return $this;
    }
}
