<?php

namespace App\Tasks\Shared\Domain;

use App\Shared\Domain\ColorValueObject;


final  class TaskColor extends ColorValueObject{
    public function __construct(protected string $value) {
        parent::__construct($value);
    }
}