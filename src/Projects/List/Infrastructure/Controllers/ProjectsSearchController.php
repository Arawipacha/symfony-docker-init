<?php

declare(strict_types=1);

namespace App\Projects\List\Infrastructure\Controllers;

use App\Projects\List\Application\ProjectsLister;
use App\Projects\List\Application\SearchProjects;
use App\Projects\List\Infrastructure\Filter\ProjectFilter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProjectsSearchController
{
    public function __construct(
        private ProjectsLister $orderLister,
        private SearchProjects $useCaseSearch
        )
    {
    }

    #[Route(path: '/api/projects', methods: ['GET','HEAD'], name: 'projects-search')]
    public function __invoke(Request $request): JsonResponse
    {
        //inject on instance of ProjectLister in your contructor
        //$response = ($this->orderLister)();

        $filter = ProjectFilter::create(
            1,
            10,
            'id',
            $request->get('order')?? 'asc',
            $request->get('name')?? null,
        );

        $response = $this->useCaseSearch->execute($filter);
        $jsonData = json_encode($response->items, JSON_PRETTY_PRINT);
        return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
    }
}
