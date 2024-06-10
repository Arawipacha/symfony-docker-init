<?php

declare(strict_types=1);

namespace App\Shared\Domain;

abstract class IntValueObject
{
    public function __construct(protected int $value)
    {
        $this->maximumValueNotExceeded();
    }

    public function value(): int
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value() === $other->value();
    }

    public function __toString(): string
    {
        return (string)$this->value();
    }

    private function maximumValueNotExceeded(): void
    {
        if ($this->value() > PHP_INT_MAX) {
            throw new \InvalidArgumentException('Number is too big');
        }
    }
}