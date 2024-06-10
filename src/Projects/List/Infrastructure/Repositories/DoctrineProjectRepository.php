<?php


declare(strict_types=1);

namespace App\Projects\List\Infrastructure\Repositories;

//use App\Entity\Project;
use App\Projects\Shared\Domain\Project;
use App\Projects\List\Domain\ProjectDomainRepository;
use App\Projects\List\Infrastructure\Repositories\Persistence\Doctrine\DoctrineRepository;
use App\Repository\ProjectRepository;
use App\Shared\Domain\Response\PaginatedResponse;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;


//class DoctrineProjectRepository extends ProjectRepository implements ProjectDomainRepository
class DoctrineProjectRepository extends DoctrineRepository implements ProjectDomainRepository
{
    /* public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry);
    } */


    public function searchAllProjects(): array
    {   
        $data = $this->searchAll(Project::class);

        //$data = $this->findAll(Project::class);
        /* $data=array_map(function(Project $item){
            return ProjectDomain::create($item->getId(),$item->getName());
        },$data); */
        
        return $data;
    }

    public function search($filter): PaginatedResponse
    {   
        
        $page= $filter->page;
        $limit = $filter->limit;
        $sort = $filter->sort;
        $order = $filter->order;
        $name = $filter->name;
        /* $from = $filter->from ?: \Datetime::createFromFormat('Y-m-d','2024-01-01') ;
        $to = $filter->to ?: \Datetime::createFromFormat('Y-m-d','2024-01-01') ;; */

        $qb = $this->entityRepository(Project::class);
        $qb = $qb->createQueryBuilder('b');
        $qb->orderBy(sprintf('b.%s',"$sort.value"),$order);
        if($name !== null){
            $qb->andWhere('b.name.value LIKE :name')
            ->setParameter('name', "%$name%");
        }

        $paginator = new Paginator($qb->getQuery());
        $paginator->getQuery()
        ->setFirstResult($limit * ($page -1))
        ->setMaxResults($limit);
        return PaginatedResponse::create(((Object)$paginator->getIterator())->getArrayCopy(),$paginator->count(),$page,$limit);
        /* return PaginatedResponse::create(((Object)$paginator->getIterator())->getArrayCopy(),$paginator->count(),$page,$limit,
        function($items){
            return array_map(function(Project $item){
                return ProjectDomain::create($item->getId(),$item->getName());
            },$items);
        }); */
    }
}
