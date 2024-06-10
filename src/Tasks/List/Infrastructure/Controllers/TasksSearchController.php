<?php

declare(strict_types=1);

namespace App\Tasks\List\Infrastructure\Controllers;


use App\Tasks\List\Application\SearchTasks;
use App\Tasks\List\Infrastructure\Filter\TaskFilter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class TasksSearchController
{
    public function __construct(
        private SearchTasks $useCaseSearch
        )
    {
    }

    #[Route(path: '/api/project/{id}/tasks', methods: ['GET','HEAD'], name: 'tasks-search')]
    public function __invoke(Request $request): JsonResponse
    {
        //inject on instance of ProjectLister in your contructor
        //$response = ($this->orderLister)();

        $filter = TaskFilter::create(
            1,
            10,
            'id',
            $request->get('order')??'asc',
            $request->get('project_id'),
            $request->get('name')??null,
        );

        $response = $this->useCaseSearch->execute($filter);
        $jsonData = json_encode($response->items, JSON_PRETTY_PRINT);
        return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
    }
}
