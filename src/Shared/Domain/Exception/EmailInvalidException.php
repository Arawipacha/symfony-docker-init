<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

use InvalidArgumentException;

class EmailInvalidException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('The email address is not valid.');
    }
}