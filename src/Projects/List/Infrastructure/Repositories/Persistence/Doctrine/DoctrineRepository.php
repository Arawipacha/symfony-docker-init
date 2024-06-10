<?php

declare(strict_types=1);

namespace App\Projects\List\Infrastructure\Repositories\Persistence\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineRepository
{
    public function __construct(protected EntityManagerInterface $entityManager)
    {
    }

    public function searchAll(string $entity): array
    {
        return $this->entityManager->getRepository($entity)->findAll();
    }

    public function entityRepository(string $entity): EntityRepository
    {
        return $this->entityManager->getRepository($entity);
    }
}