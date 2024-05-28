<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    
    /* #[ORM\Column]
    private ?int $project_id = null;
 */
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    private ?\DateTimeInterface $ini = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fine = null;

    #[ORM\Column(length: 10)]
    private ?string $color = '#4287f5';

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $per = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Project $project = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getIni(): ?\DateTimeInterface
    {
        return $this->ini;
    }

    public function setIni(?\DateTimeInterface $ini): static
    {
        $this->ini = $ini;

        return $this;
    }

    public function getFine(): ?\DateTimeInterface
    {
        return $this->fine;
    }

    public function setFine(?\DateTimeInterface $fine): static
    {
        $this->fine = $fine;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getPer(): ?int
    {
        return $this->per;
    }

    public function setPer(int $per): static
    {
        $this->per = $per;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }

}
