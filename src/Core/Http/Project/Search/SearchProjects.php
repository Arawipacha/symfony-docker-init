<?php

declare(strict_types=1);

namespace App\Core\Http\Project\Search;

use App\Core\Http\API\Filter\ProjectFilter;
use App\Projects\List\Application\Response\DTO\SearchProjectsOutputDTO;
//use App\Core\Http\Project\Search\DTO\SearchProjectsOutputDTO;
use App\Repository\ProjectRepository ;



final  class SearchProjects{
    public function __construct(private readonly ProjectRepository $projectRepository) {}

    public function execute(ProjectFilter $filter) : SearchProjectsOutputDTO {
        $paginateResponse =  $this->projectRepository->search($filter);

        return SearchProjectsOutputDTO::createFromPaginatedResponse($paginateResponse);
    }
}