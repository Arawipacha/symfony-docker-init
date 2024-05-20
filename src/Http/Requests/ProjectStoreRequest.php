<?php
declare(strict_types=1);
namespace App\Http\Requests;

use App\Core\Contracts\FormRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class ProjectStoreRequest implements FormRequest{
    
    #[Assert\NotBlank(), Assert\Length(min:2)]
    private ?string $name;

    //private ?array $data;

    public function __construct(Request $request) {
        $data = json_decode($request->getContent(),true);
        $this->name=$data['name'] ?? null;
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
    
    
}