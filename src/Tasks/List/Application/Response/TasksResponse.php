<?php

declare(strict_types=1);

namespace App\Tasks\List\Application\Response;

class TasksResponse
{
    private $projects;
    public function __construct(TaskResponse ...$projects)
    {
        $this->projects = $projects;
    }


    public function getProjects(): array
    {
        return $this->projects;
    }
    
}
