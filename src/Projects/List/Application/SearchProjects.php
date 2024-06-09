<?php

declare(strict_types=1);

namespace App\Projects\List\Application;

use App\Projects\List\Application\Response\DTO\SearchProjectsOutputDTO;
use App\Projects\List\Application\Response\ProjectResponse;
use App\Projects\List\Application\Response\ProjectsResponse;
use App\Projects\List\Domain\ProjectDomainRepository;
use App\Projects\List\Infrastructure\Filter\ProjectFilter;

class SearchProjects
{
    public function __construct(private ProjectDomainRepository $projectRepository)
    {
    }

    public function execute(ProjectFilter $filter): SearchProjectsOutputDTO
    {
        //$projects = $this->projectRepository->searchAllProjects();
        $projects =  $this->projectRepository->search($filter);

        

         return SearchProjectsOutputDTO::createFromPaginatedResponse($projects);
    }


    /*@param  \App\Projects\List\Domain\Project[] $projects
    * @return \App\Projects\List\Application\Response\ProjectResponse[]
    */
    public function toResponse(mixed $projects): SearchProjectsOutputDTO
    {

        return SearchProjectsOutputDTO::createFromPaginatedResponse($projects);

        /* $projectsResponse = [];
        foreach($projects->items as  $project) {
            $projectsResponse[] = new ProjectResponse($project->id->value, $project->name->value());
        }
        return $projectsResponse; */


    }
}
