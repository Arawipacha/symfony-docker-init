<?php

declare(strict_types=1);

namespace App\Tasks\Shared\Domain;

use App\Projects\Shared\Domain\Project;

readonly final class Task
{
    //#[\Attribute(\Attribute::TARGET_CLASS)]
    public function __construct(
        public TaskId $id,
        public TaskProjectId $project_id,
        public TaskName $name,
        
        public TaskDateIni $ini,
        public TaskDateFine $fine,
        public TaskColor $color,
        public TaskPercent $per,
        public ?Project $project=null
    ) {
    }

    public static function create(
        int $id,
        int $project_id,
        string $name,
        string $ini,
        string $fine,
        string $color,
        int $per,
        //Project $project=null
    ): self {
        return new self(
            new TaskId($id),
            new TaskProjectId($project_id),
            new TaskName($name),
            new TaskDateIni($ini),
            new TaskDateFine($fine),
            new TaskColor($color),
            new TaskPercent($per),
            //$project
        );
    }

    public function getProject(): Project
    {
        return $this->project;
    }

    public function setProject(Project $project): void
    {
        $this->project = $project;
    }

}
