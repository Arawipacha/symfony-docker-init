<?php

declare(strict_types=1);

namespace App\Projects\List\Application\Response;

class ProjectsResponse
{
    private $projects;
    public function __construct(ProjectResponse ...$projects)
    {
        $this->projects = $projects;
    }


    public function getProjects(): array
    {
        return $this->projects;
    }
    
}
