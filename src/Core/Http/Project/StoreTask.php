<?php

declare(strict_types=1);

namespace App\Core\Http\Project;

use App\Core\Contracts\FormRequest;
use App\Core\Http\API\Resources\BaseResource;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Resources\TaskResource;
use App\Repository\TaskRepository;

final class StoreTask{
    public function __construct(private readonly TaskRepository $taskRepository) {}


    public function execute(FormRequest $request) : BaseResource {
        if($request instanceof TaskStoreRequest){
            $entityProject =  $this->taskRepository->create($request);
        }

        if($request instanceof TaskUpdateRequest){
            $entityProject =  $this->taskRepository->update($request);
        }

        if(!isset($entityProject)){
            throw new \Exception("not implement Request store");
        }
        

        return TaskResource::createFromEntity($entityProject);
    }
}