<?php

declare(strict_types=1);

namespace App\Tasks\List\Application;


use App\Tasks\List\Application\Response\DTO\SearchTasksOutputDTO;
use App\Tasks\List\Domain\TaskDomainRepository;
use App\Tasks\List\Infrastructure\Filter\TaskFilter;

class SearchTasks
{
    public function __construct(private TaskDomainRepository $projectRepository)
    {
    }

    public function execute(TaskFilter $filter): SearchTasksOutputDTO
    {
        $projects =  $this->projectRepository->searchTaskByProjectId($filter);
        
        return SearchTasksOutputDTO::createFromPaginatedResponse($projects);
    }


    /*@param  \App\Projects\List\Domain\Project[] $projects
    * @return \App\Projects\List\Application\Response\ProjectResponse[]
    */
    public function toResponse(mixed $projects): SearchTasksOutputDTO
    {

        return SearchTasksOutputDTO::createFromPaginatedResponse($projects);

        /* $projectsResponse = [];
        foreach($projects->items as  $project) {
            $projectsResponse[] = new ProjectResponse($project->id->value, $project->name->value());
        }
        return $projectsResponse; */


    }
}
