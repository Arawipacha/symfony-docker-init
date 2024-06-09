<?php

declare(strict_types=1);

namespace App\Projects\List\Domain;

use App\Shared\Domain\Response\PaginatedResponse;

interface ProjectDomainRepository
{
    public function searchAllProjects(): array;
    public function search($filter): PaginatedResponse;
}
