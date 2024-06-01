<?php

declare(strict_types=1);

namespace App\Projects\List\Domain;

class Project
{
    public function __construct(
        private int $projectId,
        private string $name
    ) {
    }

    public static function create(
        int $projectId,
        string $name
    ): self {
        return new self($projectId, $name);
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function getProjectId(): int
    {
        return $this->projectId;
    }
}
