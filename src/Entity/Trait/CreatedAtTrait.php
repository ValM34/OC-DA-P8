<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

trait CreatedAtTrait
{
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
