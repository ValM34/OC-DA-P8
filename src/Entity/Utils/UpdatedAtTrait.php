<?php

namespace App\Entity\Utils;

use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

trait UpdatedAtTrait
{
    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
