<?php

declare(strict_types=1);

namespace App\Projects\Shared\Domain;

readonly final class Project
{
    public function __construct(
        public ProjectId $id,
        public ProjectName $name
    ) {
    }

    public static function create(
        int $id,
        string $name
    ): self {
        return new self(new ProjectId($id), new ProjectName($name));
    }


}
