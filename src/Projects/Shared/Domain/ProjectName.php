<?php

namespace App\Projects\Shared\Domain;

use App\Projects\Shared\Domain\Exceptions\ProjectsNameLengthException;
use App\Shared\Domain\StringValueObject;

final  class ProjectName extends StringValueObject{
    public function __construct(protected string $value) {
        $this->validateLength($value);
    }

    private function validateLength(string $value):void {
        if(strlen($value)>50){
            throw new ProjectsNameLengthException();
        }
    }
}