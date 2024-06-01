<?php

declare(strict_types=1);

namespace App\Projects\List\Domain\Exceptions;

use RuntimeException;

class ProjectsNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct("projects not found");
    }
}
