<?php

namespace App\Repository;

use App\Core\Domain\Repository\RegisterEmployee;
use App\Entity\Employee;
use App\Entity\User;
use App\Http\Requests\RegisterEmployeeRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @extends ServiceEntityRepository<Employee>
 */
class EmployeeRepository extends ServiceEntityRepository implements  RegisterEmployee
{
    public function __construct(ManagerRegistry $registry,private UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct($registry, Employee::class);
    }

    public function create(RegisterEmployeeRequest $data):User{
        $user = new Employee();
        $user->setUsername($data->getUserName());
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $data->getPassword()
        );
        
        $user->setPassword($hashedPassword);
        $user->setProfession($data->getProfession());
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        return $user;
    }

}
