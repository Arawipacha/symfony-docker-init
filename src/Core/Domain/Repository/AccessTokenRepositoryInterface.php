<?php

//declare(strict_types=1);
declare(strict_types=1);

namespace App\Core\Domain\Repository;

use App\Entity\User;
use App\Http\Requests\RegisterUserRequest;

interface AccessTokenRepositoryInterface
{
    public function findByUserByToken(string $token, string $class): ?User;
    //public function update():AccessToken;

}

