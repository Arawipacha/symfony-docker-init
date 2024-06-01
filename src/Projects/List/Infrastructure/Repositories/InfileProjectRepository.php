<?php


declare(strict_types=1);

namespace App\Projects\List\Infrastructure\Repositories;

use App\Projects\List\Domain\Project;
use App\Projects\List\Domain\ProjectRepository;

class InfileProjectRepository implements ProjectRepository
{
    private $projects = [];
    public function __construct()
    {
        $this->projects = [
        Project::create(1, "Test1"),
        Project::create(1, "Test 2")
  ];
    }


    public function searchAllProjects(): array
    {
        return $this->projects;
    }
}
