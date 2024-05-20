<?php
//declare(strict_types=1);
namespace App\Controller;

use App\Core\Http\API\Filter\ProjectFilter;
use App\Core\Http\Project\Search\SearchProjects;
use App\Http\Requests\RegisterRequest;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

class RegisterAction extends
AbstractController
{

    public function __construct(private readonly SearchProjects $useCase)
    {
    }
    //#[Route("api/register/ricette/{slug}-{id}", name:"api_register", requirements:['id'=>'\d+', 'slug'=>'[a-z0-9]'])] // esto sirve para validar y 
    //public function register(RegisterRequest $registerRequest, string $slug, int $id):JsonResponse
    #[Route("api/register", methods: ["POST"], name: "api_register_api")]
    public function __invoke(RegisterRequest $registerRequest, ProjectRepository $repo): JsonResponse
    {
        //$this->denyAccessUnlessGranted('ROLE_USER');

        
        $data = [
            'name' => $registerRequest->getName(),
            'email' => $registerRequest->getEmail(),
        ];
        return new JsonResponse($data);
    }
    
    
    #[Route("register", methods: ["POST"], name: "api_register")]
    public function register(RegisterRequest $registerRequest): JsonResponse
    {
        //$this->denyAccessUnlessGranted('ROLE_USER');

        
        $data = [
            'name' => $registerRequest->getName(),
            'email' => $registerRequest->getEmail(),
        ];
        return new JsonResponse($data);
    }

    //#[Route("/", methods:["GET"], name:"WELCOME")]
    public function index(Environment $twig): Response
    {
        return new Response($twig->render('base.html.twig'));
    }



    public function searchProject(RegisterRequest $request): Response
    {

        $filter = ProjectFilter::create(
            1,
            10,
            null,
            null,
            null,
            null
        );

        $response = $this->useCase->execute($filter);

        return $this->json($response->projects);

    }
}
