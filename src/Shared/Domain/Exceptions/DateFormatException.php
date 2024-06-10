<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exceptions;

use RuntimeException;

class DateFormatException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct("Invalid date format. Expected format: Y-m-d");
    }
}
