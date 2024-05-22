<?php
declare(strict_types=1);

namespace App\Core\Domain\Repository;


use App\Entity\AccessToken;
use App\Entity\NewAccessToken;

interface ApiToken{
    
    public function tokens():array;
    public function createToken($entity, string $name,array $abilities = ['*'],\DateTimeInterface $expiresAt = null):NewAccessToken;
    public function tokenCan(string $ability):bool;
}