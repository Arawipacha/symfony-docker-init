<?php
declare(strict_types=1);

namespace App\Core\Domain\Repository;



use App\Entity\User;
use App\Http\Requests\RegisterEmployeeRequest;



interface RegisterEmployee{
    
    public function create(RegisterEmployeeRequest $data):User;
    //public function update():AccessToken;
    
}