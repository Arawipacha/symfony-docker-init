<?php

declare(strict_types=1);

namespace App\Tasks\List\Domain;

use App\Shared\Domain\Response\PaginatedResponse;

interface TaskDomainRepository
{
    //public function searchAllProjects(): array;
    public function searchTaskByProjectId($filter): PaginatedResponse;
}
