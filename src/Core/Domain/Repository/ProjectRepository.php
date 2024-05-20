<?php
declare(strict_types=1);

namespace App\Core\Domain\Repository;

use App\Core\Http\API\Filter\ProjectFilter;
use App\Core\Http\API\Response\PaginatedResponse;
use App\Core\Project\Result\ProjectResource;
use App\Entity\Project;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;

interface ProjectRepository{
    public function search(ProjectFilter $filter):PaginatedResponse;
    public function createProject(ProjectStoreRequest $data):Project;
    public function UpdateProject(ProjectUpdateRequest $data):Project;
}