<?php

namespace App\Tasks\Shared\Domain;

use App\Tasks\Shared\Domain\Exceptions\TasksNameLengthException;
use App\Shared\Domain\StringValueObject;

final  class TaskName extends StringValueObject{
    public function __construct(protected string $value) {
        $this->validateLength($value);
    }

    private function validateLength(string $value):void {
        if(strlen($value)>50){
            throw new TasksNameLengthException();
        }
    }
}