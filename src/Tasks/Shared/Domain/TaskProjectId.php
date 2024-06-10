<?php

namespace App\Tasks\Shared\Domain;

use App\Shared\Domain\IntValueObject;

 final  class TaskProjectId extends IntValueObject{
    public function __construct(protected int $value) {
    }
}