<?php
declare(strict_types=1);
namespace App\Http\Requests;

use App\Core\Contracts\FormRequest;
use DateTimeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class TaskUpdateRequest  implements FormRequest {

    #[Assert\Positive()]
    private int $id;

    #[Assert\Positive()]
    private int $project_id;

    #[Assert\NotBlank(), Assert\Length(min:2)]
    private string $name;

    #[Assert\NotBlank(), Assert\DateTime(format:'Y-m-d\TH:i')]
    private string $ini;

    #[Assert\NotBlank(), Assert\DateTime(format:'Y-m-d\TH:i')]
    private string $fine;

    #[Assert\CssColor()]
    private ?string $color;

    #[Assert\PositiveOrZero(),Assert\Range(min:0,max:100)]
    private ?int $per;

public function __construct(
    Request $request
) {
    $data = json_decode($request->getContent(),true);
    $this->id=$data['id'];
    $this->project_id=$data['project_id'];
    $this->name=$data['name'];
    $this->ini= $data['ini'];// str_replace('T', ' ', $data['ini']);
    $this->fine= $data['fine']; // str_replace('T', ' ', $data['fine']);
    $this->color=$data['color'] ?? null;
    $this->per=$data['per'] ?? 0;
    
}





public function toArray():array
{
    return (array) $this;
}





    /**
     * Get the value of project_id
     */ 
    public function getProject_id()
    {
            return $this->project_id;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
            return $this->name;
    }

    /**
     * Get the value of ini
     */ 
    public function getIni()
    {
            return $this->ini;
    }

    /**
     * Get the value of fine
     */ 
    public function getFine()
    {
            return $this->fine;
    }

    /**
     * Get the value of color
     */ 
    public function getColor()
    {
            return $this->color;
    }

    /**
     * Get the value of per
     */ 
    public function getPer()
    {
            return $this->per;
    }   

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }
}