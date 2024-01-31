<?php

namespace App\Entity;

use App\Repository\ResponseOfQuestionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ResponseOfQuestionRepository::class)]
class ResponseOfQuestion
{
    #[Groups(['game:read-one'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'responses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $response = null;
    #[Groups(['game:read-one'])]
    #[ORM\Column]
    private ?bool $isTrue = null;
    #[Groups(['game:read-one'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $explication = null;
    #[Groups(['game:read-one'])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $valueResponse = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResponse(): ?Question
    {
        return $this->response;
    }

    public function setResponse(?Question $response): static
    {
        $this->response = $response;

        return $this;
    }

    public function isIsTrue(): ?bool
    {
        return $this->isTrue;
    }

    public function setIsTrue(bool $isTrue): static
    {
        $this->isTrue = $isTrue;

        return $this;
    }

    public function getExplication(): ?string
    {
        return $this->explication;
    }

    public function setExplication(?string $explication): static
    {
        $this->explication = $explication;

        return $this;
    }

    public function getValueResponse(): ?string
    {
        return $this->valueResponse;
    }

    public function setValueResponse(string $valueResponse): static
    {
        $this->valueResponse = $valueResponse;

        return $this;
    }

}
