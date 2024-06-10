<?php

declare(strict_types=1);

namespace App\Tasks\List\Application\Response;

final readonly class TaskResponse
{
    public function __construct(public int $id, public string $name)
    {
    }




}
