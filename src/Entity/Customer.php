<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer extends User
{

    #[ORM\Column(length: 20)]
    private ?string $ci = null;


    public function getCi(): ?string
    {
        return $this->ci;
    }

    public function setCi(string $ci): static
    {
        $this->ci = $ci;

        return $this;
    }
}
