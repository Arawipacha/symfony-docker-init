<?php

declare(strict_types=1);

namespace App\Projects\Shared\Domain;

use App\Tasks\Shared\Domain\Task;
use Doctrine\Common\Collections\ArrayCollection;

 class Project
{
    public function __construct(
        public ProjectId $id,
        public ProjectName $name,
        /**
         * @var App\Tasks\Shared\Domain\Task[]
         */
        public array $tasks=[]
    ) {
    }

    public static function create(
        int $id,
        string $name
    ): self {
        return new self(new ProjectId($id), new ProjectName($name));
    }

    public function getTasks(): array
    {
        return $this->tasks;
    }

    public function addTask(Task $task): void
    {
        $this->tasks[] = $task;
        $task->setProject($this);
    }
}
