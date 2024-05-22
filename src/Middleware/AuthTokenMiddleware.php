<?php
namespace App\Middleware;

use Symfony\Bundle\FrameworkBundle\Routing\Attribute\AsRoutingConditionService;
use Symfony\Component\HttpFoundation\Request;

#[AsRoutingConditionService(alias: 'route_checker')]
class AuthTokenMiddleware
{
    public function check(Request $request): bool
    {
        $auth = $request->headers->has('Authorization') && preg_match('/^Bearer (.+)$/', $request->headers->get('Authorization'), $matches);

        return $auth;
    }
}