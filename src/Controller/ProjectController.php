<?php

namespace App\Controller;

use App\Core\Http\API\Filter\ProjectFilter;
use App\Core\Http\Project\Search\SearchProjects;
use App\Core\Http\Project\StoreProject;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjectController extends AbstractController
{

    public function __construct(
        private readonly SearchProjects $useCaseFilter,
        private readonly StoreProject $useCaseStore,
         ) {
    }


    #[Route('/api/projects', methods:["GET"], name: 'app_search_projects')]
    public function all(Request $request): Response
    {
    
        $filter = ProjectFilter::create(
            1,
            10,
            'id',
            $request->get('order'),
            $request->get('name'),
        );

        $response1 = $this->useCaseFilter->execute($filter);
        return $this->json($response1->projects);
    }


    #[Route('/api/projects', methods:["POST"], name: 'app_store_project')]
    public function store(ProjectStoreRequest $request): Response
    {
        $response = $this->useCaseStore->execute($request);
        return $this->json($response->projects);
    }

    #[Route('/api/projects', methods:["PUT"], name: 'app_update_project')]
    public function update(ProjectUpdateRequest $request): Response
    {
        $response = $this->useCaseStore->execute($request);
        return $this->json($response->projects);
    }
}
