<?php

declare(strict_types=1);

namespace App\Projects\List\Domain;

readonly final class Project
{
    public function __construct(
        public ProjectId $id,
        public ProjectName $name
    ) {
    }

    public static function create(
        int $projectId,
        string $name
    ): self {
        return new self(new ProjectId($projectId), new ProjectName($name));
    }


}
