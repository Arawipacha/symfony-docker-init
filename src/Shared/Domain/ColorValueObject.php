<?php
declare(strict_types=1);

namespace App\Shared\Domain;

use App\Shared\Domain\Exceptions\ColorFormatException;

abstract class ColorValueObject{

    //protected string $value;

    public function __construct(protected string $value)
    {
        $this->ensureIsValidColor($value);
        //$this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value() === $other->value();
    }

    public function __toString(): string
    {
        return $this->value();
    }

    private function ensureIsValidColor(string $value): void
    {
        if (!preg_match('/^#[0-9A-Fa-f]{6}$/', $value)) {
            throw new ColorFormatException($value);
        }
    }

}