<?php
// src/Security/AccessTokenHandler.php
namespace App\Security;

use App\Core\Domain\Repository\AccessTokenRepositoryInterface;
use App\Entity\User;
use App\Repository\AccessTokenRepository;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class AccessTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(
        private AccessTokenRepositoryInterface $repository
    ) {
    }

    public function getUserBadgeFrom(string $accessToken): UserBadge
    {
        // e.g. query the "access token" database to search for this token
        $user = $this->repository->findByUserByToken($accessToken,User::class);

        /* if (null === $user || !$user->getAccessToken()->isValid()) {
            throw new BadCredentialsException('Invalid credentials.');
        } */

        // and return a UserBadge object containing the user identifier from the found token
        // (this is the same identifier used in Security configuration; it can be an email,
        // a UUUID, a username, a database ID, etc.)
        return  new UserBadge($accessToken, function($token)use($user){
            /* $user =  $this->userRepository->findBy(['token'=>$token]);
            if(!$user){
                throw new UserNotFoundException();
            } */
            return $user;
        });
    }
}