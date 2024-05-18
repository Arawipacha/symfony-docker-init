<?php
//declare(strict_types=1);
namespace App\Controller;

use App\Http\Requests\RegisterRequest;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class RegisterAction {

    public function __construct() {
        
    }
    //#[Route("api/register/ricette/{slug}-{id}", name:"api_register", requirements:['id'=>'\d+', 'slug'=>'[a-z0-9]'])] // esto sirve para validar y 
    //public function register(RegisterRequest $registerRequest, string $slug, int $id):JsonResponse
    #[Route("api/register", methods:["POST"], name:"api_register")]
    public function __invoke(RegisterRequest $registerRequest, ProjectRepository $repo):JsonResponse
    {
        //$p= $repo->find()
        $data=[
            'name'=>$registerRequest->getName(),
            'email'=>$registerRequest->getEmail(),
        ];
        return new JsonResponse($data);
    }
}