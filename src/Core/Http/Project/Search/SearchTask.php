<?php

declare(strict_types=1);

namespace App\Core\Http\Project\Search;

use App\Core\Http\API\Filter\QueryFilter;
use App\Core\Http\API\Filter\TaskFilter;
use App\Core\Http\Project\Search\DTO\SearchTasksOutputDTO;
use App\Repository\TaskRepository;



final class SearchTask{
    public function __construct(private readonly TaskRepository $taskRepository) {}

    public function execute(TaskFilter $filter) : SearchTasksOutputDTO {
        $paginateResponse =  $this->taskRepository->search($filter);

        return SearchTasksOutputDTO::createFromPaginatedResponse($paginateResponse);
    }
}