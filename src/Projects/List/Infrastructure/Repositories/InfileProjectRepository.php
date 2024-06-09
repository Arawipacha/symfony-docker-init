<?php


declare(strict_types=1);

namespace App\Projects\List\Infrastructure\Repositories;

use App\Entity\Project as EntityProject;
use App\Projects\List\Domain\Project;
use App\Projects\List\Domain\ProjectDomainRepository;
use App\Repository\ProjectRepository;
use Doctrine\Persistence\ManagerRegistry;



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
}
