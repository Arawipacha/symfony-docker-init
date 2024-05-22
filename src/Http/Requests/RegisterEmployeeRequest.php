<?php
declare(strict_types=1);
namespace App\Http\Requests;

use App\Core\Contracts\FormRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class RegisterEmployeeRequest implements FormRequest{
    
    #[Assert\NotBlank(), Assert\Length(min:2)]
    private ?string $username;

    #[Assert\NotBlank(), Assert\Length(min:2)]
    private ?string $password;

    #[Assert\NotBlank(), Assert\Email()]
    private ?string $email;
    
    #[Assert\NotBlank()]
    private ?string $profession;

    public function __construct(Request $request) {
        $data = json_decode($request->getContent(),true);
        $this->username=$data['username'] ?? null;
        $this->email=$data['email'] ?? null;
        $this->password=$data['password'] ?? null;
        $this->profession=$data['profession'] ?? null;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail():string
    {
        return $this->email;
    }

    /**
     * Get the value of nme
     */ 
    public function getUserName():string
    {
        return $this->username;
    }

    public function toArray():array
    {
        return (array) $this;
    }


    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the value of profession
     */ 
    public function getProfession()
    {
        return $this->profession;
    }
}