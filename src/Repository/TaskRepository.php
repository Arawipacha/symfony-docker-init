<?php

namespace App\Repository;

use App\Core\Domain\Repository\BaseRepository;

use App\Entity\Task;
use App\Shared\Domain\Response\PaginatedResponse;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository implements BaseRepository
{
    public function __construct(ManagerRegistry $registry, private ProjectRepository $projectRepository)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @param  \App\Core\Http\API\Filter\TaskFilter $filter
     */
    public function search($filter):PaginatedResponse{

        $page= $filter->page;
        $limit = $filter->limit;
        $sort = $filter->sort;
        $order = $filter->order;
        $name = $filter->name;
        $project_id = $filter->project_id;
        /* $from = $filter->from ?: \Datetime::createFromFormat('Y-m-d','2024-01-01') ;
        $to = $filter->to ?: \Datetime::createFromFormat('Y-m-d','2024-01-01') ;; */

        $qb = $this->createQueryBuilder('b');
        $qb->orderBy(sprintf('b.%s',$sort),$order)
        ->leftJoin('App\Entity\Project', 'p', \Doctrine\ORM\Query\Expr\Join::WITH, 'b.project = p.id')
        ->andWhere('p.id = :project_id')
        ->setParameter('project_id', $project_id);
        

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
     * @param \App\Http\Requests\TaskStoreRequest $data
     */
    public function create($data):Task{
        $project = $this->projectRepository->find($data->getProject_id());

        if(null == $project){
            throw new NotFoundHttpException("Not found project");
        }
        
        $task = new Task();
        $task->setName($data->getName());
        $task->setIni(new DateTime($data->getIni()));
        $task->setFine(new DateTime($data->getFine()));
        $task->setColor($data->getcolor());
        $task->setPer($data->getPer());
        $task->setProject($project);
        
        $this->getEntityManager()->persist($task);

        $this->getEntityManager()->flush();

        return $task;
    }

    /**
     * @param \App\Http\Requests\TaskUpdateRequest $data
     * @return \App\Entity\Task
     */
    public function update($data):Task{
        /**
         * @var \App\Entity\Task
         */
        $task = $this->find($data->getId());
        
        $task->setName($data->getName());
        $task->setIni(new DateTime($data->getIni()));
        $task->setFine(new DateTime($data->getFine()));
        $task->setColor($data->getcolor());
        $task->setPer($data->getPer());
    
        $this->getEntityManager()->persist($task);
        $this->getEntityManager()->flush();

        if (!$task) {
            throw $this->createNotFoundException(
                'No project found for id '.$data->getId()
            );
        }

        $task->setName($data->getName());
        $this->getEntityManager()->flush();
        
        return $task;
    }
    
}
