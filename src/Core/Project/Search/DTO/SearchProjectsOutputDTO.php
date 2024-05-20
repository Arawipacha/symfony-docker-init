<?php
declare(strict_types=1);

namespace App\Core\Project\Search\DTO;

use App\Core\Http\API\Response\PaginatedResponse;
use App\Entity\Project;

final class SearchProjectsOutputDTO{
    public function __construct(public readonly array $projects) {
    }

    public static function createFromPaginatedResponse(PaginatedResponse $paginatedResponse) : self {
        $items = \array_map(function(Project $project):array{
            return [
                'id'=>$project->getId(),
                'name'=>$project->getName()
            ];
        }, $paginatedResponse->getItems());

        $response['items']=$items;
        $response['meta']=$paginatedResponse->getMeta();
        return new SearchProjectsOutputDTO($response);
    }
}