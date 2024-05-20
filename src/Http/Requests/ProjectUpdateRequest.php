<?php
declare(strict_types=1);
namespace App\Http\Requests;

use App\Core\Contracts\FormRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class ProjectUpdateRequest implements FormRequest{
    #[Assert\NotBlank()]
    private ?int $id;

    #[Assert\NotBlank(), Assert\Length(min:2)]
    private ?string $name;

    //private ?array $data;

    public function __construct(Request $request) {
        $data = json_decode($request->getContent(),true);
        $this->name=$data['name'] ?? null;
        $this->id=$data['id'] ?? null;
    }

    

    /**
     * Get the value of nme
     */ 
    public function getName():string
    {
        return $this->name;
    }


    public function toArray():array
    {
        return (array) $this;
    }


    /* public function toEntity():Project
    {
        return Project;
    } */
    
    

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }
}