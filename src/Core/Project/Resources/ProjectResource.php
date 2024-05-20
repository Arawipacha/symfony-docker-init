<?php
declare(strict_types=1);

namespace App\Core\Project\Resources;


use App\Entity\Project;

final class ProjectResource{
    public function __construct(public readonly array $projects) {
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
}