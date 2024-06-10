<?php
declare(strict_types=1);

namespace App\Tasks\Shared\Domain\Exceptions;

use RuntimeException;

class TasksNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct("Tasks not found");
    }
}
