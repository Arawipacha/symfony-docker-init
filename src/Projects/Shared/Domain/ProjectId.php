<?php

namespace App\Projects\Shared\Domain;

use App\Shared\Domain\IntValueObject;

 final  class ProjectId extends IntValueObject{
    public function __construct(protected int $value) {
    }
}