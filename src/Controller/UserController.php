<?php

namespace App\Controller;

use App\Core\Domain\Repository\ApiToken;
use App\Core\Domain\Repository\RegisterEmployee;
use App\Core\Domain\Repository\RegisterUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\User;
use App\Http\Requests\RegisterEmployeeRequest;
use App\Repository\EmployeeRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{

    public function __construct(
        private readonly EmployeeRepository $useCaseCreateUser,
        private readonly ApiToken $useCaseCreateToken,
    ) {
    }


    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(RegisterEmployeeRequest $request): Response
    {

        $user = $this->useCaseCreateUser->create($request);

        $token = $this->useCaseCreateToken->createToken($user, "api_token");

        return new JsonResponse([

            'user'  => $user->getUserIdentifier(),
            'token' => $token,
        ]);
    }



    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function index(#[CurrentUser] ?User $user, SerializerInterface $serializer): Response
    {
        if (null === $user) {
            return new JsonResponse([
                'message' => 'missing credentials',
            ]);
        }

        $token = $this->useCaseCreateToken->createToken($user, "api_token");
        //$data =$serializer->serialize($token,'json',[]);
        //$data=json_decode($data);
        return new JsonResponse([
            'user'  => $user->getUserIdentifier(),
            'token' =>  $token->plainTextToken,
        ]);
    }
}
