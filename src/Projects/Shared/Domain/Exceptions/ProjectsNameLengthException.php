<?php

declare(strict_types=1);

namespace App\Projects\Shared\Domain\Exceptions;

use RuntimeException;

class ProjectsNameLengthException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct("project name be longer than 50 characters.");
    }
}
