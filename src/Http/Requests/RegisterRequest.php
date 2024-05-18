<?php
declare(strict_types=1);
namespace App\Http\Requests;

use App\Core\Contracts\FormRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class RegisterRequest implements FormRequest{
    
    #[Assert\NotBlank(), Assert\Length(min:2)]
    private ?string $name;

    #[Assert\NotBlank(), Assert\Email()]
    private ?string $email;

    public function __construct(Request $request) {
        $data = json_decode($request->getContent(),true);
        $this->name=$data['name'] ?? null;
        $this->email=$data['email'] ?? null;
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
    public function getName():string
    {
        return $this->name;
    }
}