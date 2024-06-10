<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use App\Shared\Domain\Exceptions\DateFormatException;
use DateTime;

abstract class DateValueObject
{
    protected DateTime $value;

    public function __construct(string $value)
    {
        $this->value = $this->parseDate($value);
    }

    public function value(): DateTime
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value() == $other->value();
    }

    public function __toString(): string
    {
        return $this->value()->format('Y-m-d');
    }

    protected function parseDate(string $value): DateTime
    {
        $date = DateTime::createFromFormat('Y-m-d', $value);
        if (!$date || $date->format('Y-m-d') !== $value) {
            throw new DateFormatException();
        }
        return $date;
    }

}