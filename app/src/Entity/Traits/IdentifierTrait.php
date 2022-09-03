<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait IdentifierTrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}