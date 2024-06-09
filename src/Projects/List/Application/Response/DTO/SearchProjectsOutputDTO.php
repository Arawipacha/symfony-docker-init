<?php
declare(strict_types=1);

namespace App\Projects\List\Application\Response\DTO;


use App\Projects\List\Domain\Project;
use App\Shared\Domain\Response\PaginatedResponse;

//use App\Entity\Project;

final class SearchProjectsOutputDTO{
    public function __construct(public readonly array $items) {
    }

    public static function createFromPaginatedResponse(PaginatedResponse $paginatedResponse) : self {
        $items = \array_map(function(Project $project):array{
            return [
                'id'=>$project->id->value,
                'name'=>$project->name->value()
            ];
        }, $paginatedResponse->getItems());

        $response['items']=$items;
        $response['meta']=$paginatedResponse->getMeta();
        return new SearchProjectsOutputDTO($response);
    }
}