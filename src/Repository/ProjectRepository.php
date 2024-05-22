<?php

namespace App\Repository;

use App\Core\Domain\Repository\ProjectRepository as RepositoryProjectRepository;
use App\Core\Http\API\Filter\ProjectFilter;
use App\Core\Http\API\Response\PaginatedResponse;
use App\Entity\Project;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Project>
 */
class ProjectRepository extends ServiceEntityRepository implements RepositoryProjectRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }


    public function search(ProjectFilter $filter):PaginatedResponse{

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


    public function createProject(ProjectStoreRequest $data):Project{
        $project = new Project();
        
        $project->setName($data->getName());
        
        $this->getEntityManager()->persist($project);

        $this->getEntityManager()->flush();

        return $project;
    }


    public function updateProject(ProjectUpdateRequest $data):Project{
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


    //    /**
    //     * @return Project[] Returns an array of Project objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Project
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
