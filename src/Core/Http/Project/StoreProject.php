<?php

declare(strict_types=1);

namespace App\Core\Http\Project;

use App\Core\Contracts\FormRequest;
use App\Core\Project\Resources\ProjectResource;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Repository\ProjectRepository;

final class StoreProject{
    public function __construct(private readonly ProjectRepository $projectRepository) {}


    public function execute(FormRequest $request) : ProjectResource {
        if($request instanceof ProjectStoreRequest){
            $entityProject =  $this->projectRepository->createProject($request);
        }

        if($request instanceof ProjectUpdateRequest){
            $entityProject =  $this->projectRepository->updateProject($request);
        }

        if(!isset($entityProject)){
            throw new \Exception("not implement Request store");
        }
        

        return ProjectResource::createFromEntity($entityProject);
    }
}