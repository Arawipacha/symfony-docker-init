<?php

declare(strict_types=1);

namespace App\Projects\List\Domain;

interface ProjectDomainRepository
{
    public function searchAllProjects(): array;
}
