<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM; //mapage ici = on appelle bien doctrine

trait DateTraits
{
    #[ORM\Column(type:'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])] // ORM = doctrine et on a besoin d'un mapage pour qu'il marche
    private ?\DateTimeImmutable $createdAt; // ?\ = importe la class

    #[ORM\Column(type:'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $updatedAt;

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    #[ORM\PreUpdate]
    public function setUpdatedAt(): void
    {
        $this->updatedAt = new \DateTimeImmutable;

    }


    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTimeImmutable;
    }
}