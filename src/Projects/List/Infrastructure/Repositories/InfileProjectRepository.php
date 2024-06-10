<?php


declare(strict_types=1);

namespace App\Projects\List\Infrastructure\Repositories;


use App\Projects\Shared\Domain\Project;
use App\Projects\List\Domain\ProjectDomainRepository;
use App\Repository\ProjectRepository;
use App\Shared\Domain\Response\PaginatedResponse;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

class InfileProjectRepository implements ProjectDomainRepository
{
    private $projects = [];
    public function __construct()
    {
    
        $this->projects = [
        Project::create(1, "Test1"),
        Project::create(1, "Test 2")
  ];
    }


    public function searchAllProjects(): array
    {   
        
        /* $data = $this->findAll();
        $data=array_map(function(EntityProject $item){
            return Project::create($item->getId(),$item->getName());
        },$data); */
        
        return $this->projects;
    }
    public function search($filter): PaginatedResponse{
        throw new Exception('');
    }


}
