<?php

namespace App\Repository;

use App\Core\Domain\Repository\BaseRepository;



use App\Entity\Project;

use App\Shared\Domain\Response\PaginatedResponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Project>
 */
class ProjectRepository extends ServiceEntityRepository implements BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    /**
     * @param  \App\Core\Http\API\Filter\ProjectFilter $filter
     */
    public function search($filter):PaginatedResponse{

        $page= $filter->page;
        $limit = $filter->limit;
        $sort = $filter->sort;
        $order = $filter->order;
        $name = $filter->name;
        /* $from = $filter->from ?: \Datetime::createFromFormat('Y-m-d','2024-01-01') ;
        $to = $filter->to ?: \Datetime::createFromFormat('Y-m-d','2024-01-01') ;; */

        $qb = $this->createQueryBuilder('b');
        $qb->orderBy(sprintf('b.%s',$sort),$order);
        

        if($name !== null){
            $qb->andWhere('b.name LIKE :name')
        ->setParameter('name', "%$name%");
        }
        

        $paginator = new Paginator($qb->getQuery());
        $paginator->getQuery()
        ->setFirstResult($limit * ($page -1))
        ->setMaxResults($limit);
        
        return PaginatedResponse::create(((Object)$paginator->getIterator())->getArrayCopy(),$paginator->count(),$page,$limit);
    }

    /**
     * @param App\Http\Requests\ProjectStoreRequest $data
     */
    public function create($data):Project{
        $project = new Project();
        
        $project->setName($data->getName());
        
        $this->getEntityManager()->persist($project);

        $this->getEntityManager()->flush();

        return $project;
    }

    /**
     * @param \App\Http\Requests\ProjectUpdateRequest $data
     * @return \App\Entity\Project
     */
    public function update($data):Project{
        /**
         * @var \App\Entity\Project
         */
        $project = $this->find($data->getId());
        
        $project->setName($data->getName());
    
        $this->getEntityManager()->persist($project);
        $this->getEntityManager()->flush();

        if (!$project) {
            throw $this->createNotFoundException(
                'No project found for id '.$data->getId()
            );
        }

        $project->setName($data->getName());
        $this->getEntityManager()->flush();
        
        return $project;
    }

}
