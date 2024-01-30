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


    #[ORM\Column]
    private ?int $level = null;

    #[ORM\OneToMany(mappedBy: 'response', targetEntity: ResponseOfQuestion::class, orphanRemoval: true)]
    private Collection $responses;

    public function __construct()
    {
        $this->responses = new ArrayCollection();
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

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

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
}
