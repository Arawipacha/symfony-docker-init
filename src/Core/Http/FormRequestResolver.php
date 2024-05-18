<?php
declare(strict_types=1);
namespace App\Core\Http;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FormRequestResolver implements ValueResolverInterface{
    

    public function __construct(private ValidatorInterface $validator) {}
    
    public function resolve(Request $request, ArgumentMetadata $argument): iterable{
        $class = $argument->getType();
        $dto =  new $class($request);
        $errors = $this->validator->validate($dto);
        if(count($errors)>0){
            throw new BadRequestHttpException((string) $errors);
        }

        return  [$dto];
    }
}