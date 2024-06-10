<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exceptions;

use RuntimeException;

class ColorFormatException extends RuntimeException
{
    public function __construct(readonly string $value)
    {
        parent::__construct(sprintf('The color "%s" is not valid.', $value));
    }
}
