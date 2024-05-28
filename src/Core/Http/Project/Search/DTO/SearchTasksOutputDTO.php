<?php
declare(strict_types=1);

namespace App\Core\Http\Project\Search\DTO;

use App\Core\Http\API\Response\PaginatedResponse;
use App\Entity\Task;

final class SearchTasksOutputDTO{
    public function __construct(public readonly array $items) {
    }

    public static function createFromPaginatedResponse(PaginatedResponse $paginatedResponse) : self {
        $items = \array_map(function(Task $task):array{
            return [

                'id'=>$task->getId(),
                'project_id'=>$task->getProject()->getId(),
                'name'=>$task->getName(),
                'ini'=>$task->getIni()->format('Y-m-d\TH:i'),
                'fine'=>$task->getFine()->format('Y-m-d\TH:i'),
                'color'=>$task->getColor(),
                'per'=>$task->getPer(),
            ];
        }, $paginatedResponse->getItems());

        $response['items']=$items;
        $response['meta']=$paginatedResponse->getMeta();
        return new SearchTasksOutputDTO($response);
    }
}