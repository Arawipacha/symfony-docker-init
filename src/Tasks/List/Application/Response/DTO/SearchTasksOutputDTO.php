<?php
declare(strict_types=1);

namespace App\Tasks\List\Application\Response\DTO;


use App\Tasks\Shared\Domain\Task;
use App\Shared\Domain\Response\PaginatedResponse;

//use App\Entity\Project;

final class SearchTasksOutputDTO{
    public function __construct(public readonly array $items) {
    }

    public static function createFromPaginatedResponse(PaginatedResponse $paginatedResponse) : self {
        $items = \array_map(function(Task $task):array{
            return [
                'id'=>$task->id->value(),
                'project_id'=>$task->project_id->value(),
                'name'=>$task->name->value(),
                'ini'=>$task->ini->value()->format('Y-m-d\TH:i'),
                'fine'=>$task->fine->value()->format('Y-m-d\TH:i'),
                'color'=>$task->color->value(),
                'per'=>$task->per->value(),
            ];
        }, $paginatedResponse->getItems());

        $response['items']=$items;
        $response['meta']=$paginatedResponse->getMeta();
        return new SearchTasksOutputDTO($response);
    }
}