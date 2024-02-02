<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ParticipantRepository::class)]
class Participant
{
    #[Groups(['game:read-one'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[Groups(['game:read-one'])]
    #[ORM\Column(length: 255)]
    private ?string $username = null;
    #[Groups(['game:read-one'])]
    #[ORM\OneToOne(mappedBy: 'username', cascade: ['persist', 'remove'])]
    private ?Point $point = null;

    #[ORM\ManyToOne(inversedBy: 'participant')]
    private ?Party $party = null;

    #[ORM\ManyToOne(inversedBy: 'participantOfDraw')]
    private ?ParticipantOfDraw $participantOfDraw = null;



    public function __construct()
    {
        $this->parties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPoint(): ?Point
    {
        return $this->point;
    }

    public function setPoint(?Point $point): static
    {
        // unset the owning side of the relation if necessary
        if ($point === null && $this->point !== null) {
            $this->point->setUsername(null);
        }

        // set the owning side of the relation if necessary
        if ($point !== null && $point->getUsername() !== $this) {
            $point->setUsername($this);
        }

        $this->point = $point;

        return $this;
    }

    /**
     * @return Collection<int, Party>
     */

    public function getParty(): ?Party
    {
        return $this->party;
    }

    public function setParty(?Party $party): static
    {
        $this->party = $party;

        return $this;
    }

    public function getParticipantOfDraw(): ?ParticipantOfDraw
    {
        return $this->participantOfDraw;
    }

    public function setParticipantOfDraw(?ParticipantOfDraw $participantOfDraw): static
    {
        $this->participantOfDraw = $participantOfDraw;

        return $this;
    }

}
