<?php

declare(strict_types=1);

namespace App\Projects\List\Application;

use App\Projects\List\Application\Response\ProjectResponse;
use App\Projects\List\Application\Response\ProjectsResponse;
use App\Projects\Shared\Domain\Exceptions\ProjectsNotFoundException;
use App\Projects\List\Domain\ProjectDomainRepository;

class ProjectsLister
{
    public function __construct(private ProjectDomainRepository $projectRepository)
    {
    }

    /* public function __invoke(): ProjectsResponse
    {
        
        $projects = $this->projectRepository->searchAllProjects();

        if(empty($projects)) {
            throw new ProjectsNotFoundException();
        }

        return new ProjectsResponse(...$this->toResponse($projects));
    } */


    /*@param  \App\Projects\List\Domain\Project[] $projects
    * @return \App\Projects\List\Application\Response\ProjectResponse[]
    */
    public function toResponse(mixed $projects): array
    {
        $projectsResponse = [];
        foreach($projects as  $project) {
            $projectsResponse[] = new ProjectResponse($project->id->value, $project->name->value());
        }
        return $projectsResponse;


    }
}
