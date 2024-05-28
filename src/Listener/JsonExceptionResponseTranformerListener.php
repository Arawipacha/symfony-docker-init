<?php

namespace App\Listener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class JsonExceptionResponseTranformerListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $path=$event->getRequest()->getPathInfo();
        $path=str_starts_with($path, '/api');
        if(!$path){
            return ;
        }
        $data=[
            'class'=> get_class($exception),
            'code'=> JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            'message'=> $exception->getMessage(),
            'method'=> $event->getRequest()->getMethod(),
            'file'=> $exception->getFile(),
            'line'=> $exception->getLine(),
        ];
        if($exception instanceof HttpExceptionInterface){
            $data['code']= $exception->getStatusCode();
        }

        $event->setResponse($this->prepareResponse($data));
    }


    private  function prepareResponse(array $data) : JsonResponse {
        $response=  new JsonResponse($data, $data['code']);
        $response->headers->set("Server-time", time());
        $response->headers->set("X-Error-Code", $data['code']);
        return $response;
    }
}
