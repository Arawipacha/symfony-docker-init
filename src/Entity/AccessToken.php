<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Annotation\Ignore;

use App\Repository\AccessTokenRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccessTokenRepository::class)]
class AccessToken
{
    #[SerializedName('id')]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /* #[ORM\Column(length: 255)]
    private ?string $tokenable_type = null; */

    #[SerializedName('name')]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $token = null;

    #[ORM\Column(length: 255)]
    private ?string $abilities = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $last_used_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $expired_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\JoinColumn(nullable: true,name:"tokenable_id")] //opzionale
    #[ORM\ManyToOne(targetEntity:"User",inversedBy: 'tokens')]
    private ?User $tokenable = null;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    /* public function getTokenableType(): ?string
    {
        return $this->tokenable_type;
    }

    public function setTokenableType(string $tokenable_type): static
    {
        $this->tokenable_type = $tokenable_type;

        return $this;
    } */


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function getAbilities(): ?string
    {
        return $this->abilities;
    }

    public function setAbilities(string $abilities): static
    {
        $this->abilities = $abilities;

        return $this;
    }

    public function getLastUsedAt(): ?\DateTimeImmutable
    {
        return $this->last_used_at;
    }

    public function setLastUsedAt(?\DateTimeImmutable $last_used_at): static
    {
        $this->last_used_at = $last_used_at;

        return $this;
    }

    public function getExpiredAt(): ?\DateTimeImmutable
    {
        return $this->expired_at;
    }

    public function setExpiredAt(?\DateTimeImmutable $expired_at): static
    {
        $this->expired_at = $expired_at;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getTokenable(): ?User
    {
        return $this->tokenable;
    }

    public function setTokenable(?User $tokenable): static
    {
        $this->tokenable = $tokenable;

        return $this;
    }


    public function isValid(){
        if ($this->expired_at) {
            $currentDateTime = new \DateTime(); 
            if ($this->expired_at > $currentDateTime) {
                return true; 
            } else {
                return false;
            }
        }
    
        return true;
    }
}
