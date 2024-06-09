<?php


declare(strict_types=1);

namespace App\Projects\List\Infrastructure\Repositories;

use App\Entity\Project;
use App\Projects\List\Domain\Project as ProjectDomain;
use App\Projects\List\Domain\ProjectDomainRepository;
use App\Repository\ProjectRepository;
use Doctrine\Persistence\ManagerRegistry;
class DoctrineProjectRepository extends ProjectRepository implements ProjectDomainRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry);
    }


    public function searchAllProjects(): array
    {   
        
        $data = $this->findAll(Project::class);
        $data=array_map(function(Project $item){
            return ProjectDomain::create($item->getId(),$item->getName());
        },$data);
        
        return $data;
    }
}
