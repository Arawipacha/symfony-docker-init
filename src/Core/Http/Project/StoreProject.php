<?php

declare(strict_types=1);

namespace App\Core\Http\Project;

use App\Core\Contracts\FormRequest;
use App\Core\Http\API\Resources\BaseResource;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Http\Resources\ProjectResource;
use App\Repository\ProjectRepository;

final class StoreProject{
    public function __construct(private readonly ProjectRepository $projectRepository) {}


    public function execute(FormRequest $request) : BaseResource {
        if($request instanceof ProjectStoreRequest){
            $entityProject =  $this->projectRepository->create($request);
        }

        if($request instanceof ProjectUpdateRequest){
            $entityProject =  $this->projectRepository->update($request);
        }

        if(!isset($entityProject)){
            throw new \Exception("not implement Request store");
        }
        

        return ProjectResource::createFromEntity($entityProject);
    }
}