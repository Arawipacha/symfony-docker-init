<?php
declare(strict_types=1);

namespace App\Http\Resources;

use App\Core\Http\API\Resources\BaseResource;
use App\Entity\Project;

  class ProjectResource implements BaseResource{
    public function __construct(private readonly array $item) {
    }

    public static function createFromEntity(Project $project) : self {
        /* $items = \array_map(function(Project $project):array{
            return [
                'id'=>$project->getId(),
                'name'=>$project->getName()
            ];
        }, $paginatedResponse->getItems()); */

        
        return new ProjectResource(
            [
                'id'=>$project->getId(),
                'name'=>$project->getName()
            ]
        );
    }


    public function toArray():array{
        return $this->item;
    }
}