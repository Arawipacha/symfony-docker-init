<?php

declare(strict_types=1);

namespace App\Projects\List\Infrastructure\Controllers;

use App\Projects\List\Application\ProjectsLister;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProjectsListerController
{
    public function __construct(private ProjectsLister $orderLister)
    {
    }

    #[Route(path: '/api/projects/list', methods: ['GET','HEAD'], name: 'projects-list')]
    public function __invoke(): JsonResponse
    {
        //inject on instance of ProjectLister in your contructor
        //$response = ($this->orderLister)();

        $response = $this->orderLister->__invoke();
        $jsonData = json_encode(['items'=>$response->getProjects()], JSON_PRETTY_PRINT);
        return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
    }
}
