<?php

namespace App\Projects\List\Domain;

use App\Projects\List\Domain\Exceptions\ProjectsNameLengthException;
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