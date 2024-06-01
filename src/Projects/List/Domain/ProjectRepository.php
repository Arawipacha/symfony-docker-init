<?php

declare(strict_types=1);

namespace App\Projects\List\Domain;

interface ProjectRepository
{
    public function searchAllProjects(): array;
}
