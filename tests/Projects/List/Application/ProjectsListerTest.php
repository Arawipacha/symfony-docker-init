<?php

declare(strict_types=1);

namespace App\Tests\projects\list\application;

use App\Projects\List\Application\ProjectsLister;
use App\Projects\List\Application\Response\ProjectResponse;
use App\Projects\List\Application\Response\ProjectsResponse;
use App\Projects\List\Domain\Exceptions\ProjectsNotFoundException;
use App\Projects\List\Domain\Project;
use App\Projects\List\Domain\ProjectRepository;
use PHPUnit\Framework\TestCase;

class ProjectsListerTest extends TestCase
{
    public function test_should_return_list_projects(): void
    {
        $orderRepository = $this->createMock(ProjectRepository::class);
        $orderRepository->expects(self::once())
          ->method('searchAllProjects')
          ->with()
          ->willReturn([new Project(1, 'projeco 1'),new Project(2, 'projeco 1')]);

        $projectsLister = new ProjectsLister($orderRepository);
        $result = $projectsLister();

        self::assertInstanceOf(ProjectsResponse::class, $result);
        self::assertContainsOnlyInstancesOf(ProjectResponse::class, $result->getProjects());
        self::assertEquals($result->getProjects()[0]->id, 1);
    }


    public function test_should_return_exception(): void
    {

        $this->expectException(ProjectsNotFoundException::class);
        $orderRepository = $this->createMock(ProjectRepository::class);
        $orderRepository->expects(self::once())
          ->method('searchAllProjects')
          ->with()
          ->willReturn([]);

        $projectsLister = new ProjectsLister($orderRepository);
        $result = $projectsLister();


    }
}
