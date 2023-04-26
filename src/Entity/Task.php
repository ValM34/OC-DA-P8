<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\UpdatedAtTrait;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150, type: 'string')]
    #[Assert\Length(
        min: 3,
        max: 150,
        minMessage: 'Votre titre doit contenir au moins {{ limit }} caractères',
        maxMessage: 'Votre titre ne doit pas dépasser {{ limit }} caractères'
    )]
    private ?string $title = null;

    #[ORM\Column(length: 500, type: 'string')]
    #[Assert\Length(
        min: 3,
        max: 500,
        minMessage: 'Votre contenu doit contenir au moins {{ limit }} caractères',
        maxMessage: 'Votre contenu ne doit pas dépasser {{ limit }} caractères'
    )]
    private ?string $content = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $isDone = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function isIsDone(): ?bool
    {
        return $this->isDone;
    }

    public function setIsDone(bool $isDone): self
    {
        $this->isDone = $isDone;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
