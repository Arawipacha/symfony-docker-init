<?php


declare(strict_types=1);

namespace App\Tasks\List\Infrastructure\Repositories;

use App\Projects\Shared\Domain\Project;
use App\Tasks\Shared\Domain\Task;
use App\Tasks\List\Domain\TaskDomainRepository;
use App\Tasks\List\Infrastructure\Repositories\Persistence\Doctrine\DoctrineRepository;
use App\Shared\Domain\Response\PaginatedResponse;
use Doctrine\ORM\Tools\Pagination\Paginator;



//class DoctrineProjectRepository extends ProjectRepository implements ProjectDomainRepository
class DoctrineTaskRepository extends DoctrineRepository implements TaskDomainRepository
{
    /* public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry);
    } */



    public function searchTaskByProjectId($filter): PaginatedResponse
    {   
        $page= $filter->page;
        $limit = $filter->limit;
        $sort = $filter->sort;
        $order = $filter->order;
        $name = $filter->name;
        $project_id = $filter->project_id;
        /* $from = $filter->from ?: \Datetime::createFromFormat('Y-m-d','2024-01-01') ;
        $to = $filter->to ?: \Datetime::createFromFormat('Y-m-d','2024-01-01') ;; */
        $qb = $this->entityRepository(Task::class);
        $qb = $qb->createQueryBuilder('b');
        $qb->orderBy(sprintf('b.%s',"$sort.value"),$order)
        //->leftJoin('App\Entity\Project', 'p', \Doctrine\ORM\Query\Expr\Join::WITH, 'b.project = p.id')
        //->leftJoin(Project::class, 'p', \Doctrine\ORM\Query\Expr\Join::WITH, 'b.project = p.id.value')
        ->andWhere('b.project_id.value = :project_id')
        ->setParameter('project_id', $project_id);
        

        if($name !== null){
            $qb->andWhere('b.name.value LIKE :name')
        ->setParameter('name', "%$name%");
        }
        
        

        $paginator = new Paginator($qb->getQuery());
        $paginator->getQuery()
        ->setFirstResult($limit * ($page -1))
        ->setMaxResults($limit);
        
        return PaginatedResponse::create(((Object)$paginator->getIterator())->getArrayCopy(),$paginator->count(),$page,$limit);


/* 
        $page= $filter->page;
        $limit = $filter->limit;
        $sort = $filter->sort;
        $order = $filter->order;
        $name = $filter->name;
        //$from = $filter->from ?: \Datetime::createFromFormat('Y-m-d','2024-01-01') ;
        //$to = $filter->to ?: \Datetime::createFromFormat('Y-m-d','2024-01-01') ;;

        $qb = $this->entityRepository(Task::class);
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
        */ 
    }
}
