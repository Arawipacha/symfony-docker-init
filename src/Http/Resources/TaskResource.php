<?php
declare(strict_types=1);

namespace App\Http\Resources;

use App\Core\Http\API\Resources\BaseResource;
use App\Entity\Task;

 class TaskResource implements BaseResource{
    public function __construct(private readonly array $item) {
    }

    public static function createFromEntity(Task $task) : self {
        /* $items = \array_map(function(Project $project):array{
            return [
                'id'=>$project->getId(),
                'name'=>$project->getName()
            ];
        }, $paginatedResponse->getItems()); */

        
        return new TaskResource(
            [
                'id'=>$task->getId(),
                'name'=>$task->getName(),
                'ini'=>$task->getIni()->format('Y-m-d\TH:i'),
                'fine'=>$task->getFine()->format('Y-m-d\TH:i'),
                'color'=>$task->getColor(),
                'per'=>$task->getPer(),
            ]
        );
    }
    
    public function toArray():array{
        return $this->item;
    }
}