<?php

namespace App\Controller;


use App\Core\Http\API\Filter\QueryFilter;
use App\Core\Http\API\Filter\TaskFilter;
use App\Core\Http\Project\Search\SearchTask;

use App\Core\Http\Project\StoreTask;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TaskController extends AbstractController
{

    public function __construct(
        private readonly SearchTask $useCaseFilter,
        private readonly StoreTask $useCaseStore,
         ) {
    }


    #[Route('/api/project/{id}/tasks', methods:['GET', 'HEAD'], name: 'app_search_tasks',/* condition:"service('route_checker').check(request)" */)]
    public function all(Request $request): Response
    {
    
        $filter = TaskFilter::create(
            1,
            10,
            'id',
            $request->get('order')??'asc',
            $request->get('project_id'),
            $request->get('name')??null,
        );

        $response1 = $this->useCaseFilter->execute($filter);
        return $this->json($response1->items);
    }


    #[Route('/api/project/{id}/tasks', methods:["POST"], name: 'app_store_task')]
    public function store( TaskStoreRequest $request ): Response
    {
        $response = $this->useCaseStore->execute($request);
        return $this->json($response->toArray());
    }

    #[Route('/api/project/{id}/tasks', methods:["PUT"], name: 'app_update_task')]
    public function update(TaskUpdateRequest $request): Response
    {
        $response = $this->useCaseStore->execute($request);
        return $this->json($response->toArray());
    }



}
