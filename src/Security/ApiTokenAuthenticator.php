<?php

namespace App\Security;

use App\Core\Domain\Repository\AccessTokenRepositoryInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;



class ApiTokenAuthenticator extends AbstractAuthenticator
{

    public function __construct(private AccessTokenRepositoryInterface $userRepository,private Security $security) {
        
    }
    public function supports(Request $request): ?bool
    {
        if(str_starts_with($request->getPathInfo(),'/api/login') || str_starts_with($request->getPathInfo(),'/api/register')){
            return false;
        }
        
        return (str_starts_with($request->getPathInfo(),'/api/')  || ($request->headers->has('Authorization') && preg_match('/^Bearer (.+)$/', $request->headers->get('Authorization'), $matches)));
    }

    public function authenticate(Request $request): Passport
    {   
        preg_match('/^Bearer (.+)$/', $request->headers->get('Authorization'), $matches);
        $token=count($matches)>0 ? $matches[1] : null;
        if(  null === $token){
            throw new CustomUserMessageAuthenticationException("No Token provider");
        }
        return new SelfValidatingPassport(
            new UserBadge($token, function($token){
                $user =  $this->userRepository->findByUserByToken($token,'User::class');
                if(!$user){
                    throw new UserNotFoundException();
                }
                return $user;
            })

        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        
        $data =[
            'message'=> strtr($exception->getMessageKey(),$exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    //    public function start(Request $request, AuthenticationException $authException = null): Response
    //    {
    //        /*
    //         * If you would like this class to control what happens when an anonymous user accesses a
    //         * protected page (e.g. redirect to /login), uncomment this method and make this class
    //         * implement Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface.
    //         *
    //         * For more details, see https://symfony.com/doc/current/security/experimental_authenticators.html#configuring-the-authentication-entry-point
    //         */
    //    }
}
