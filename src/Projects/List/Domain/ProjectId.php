<?php

namespace App\Projects\List\Domain;

readonly final  class ProjectId{
    public function __construct(public int $value) {
    }
}