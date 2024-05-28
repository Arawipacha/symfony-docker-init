<?php

namespace App\Repository;

use App\Core\Domain\Repository\AccessTokenRepositoryInterface;
use App\Core\Domain\Repository\ApiToken;
use App\Core\Domain\Repository\RegisterEmployee;
use App\Core\Domain\Repository\RegisterUser;
use App\Entity\AccessToken;
use App\Entity\NewAccessToken;
use App\Entity\User;
use App\Http\Requests\RegisterEmployeeRequest;
use App\Http\Requests\RegisterUserRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;


use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\ByteString;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, ApiToken, AccessTokenRepositoryInterface
{
    public function __construct(ManagerRegistry $registry,private  UserPasswordHasherInterface $passwordHasher, private AccessTokenRepository $accessTokenRepository)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }
    
    
    


    public function tokens():array{

        return [];
    }

    /**
     * @param  \App\Entity\User $entity
     */
    public function createToken($entity, string $name,array $abilities = ['*'],\DateTimeInterface $expiresAt = null):NewAccessToken{
        $token =  new AccessToken();
        $token->setName($name);
        $token->setAbilities(json_encode($abilities));
        $token->setExpiredAt($expiresAt);
        $token->setToken(hash('sha256', $plainTextToken=ByteString::fromRandom(40)));

        $entity->addToken($token);
        
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->persist($token);
        $this->getEntityManager()->flush();
        
        return new NewAccessToken($token,$token->getId().'|'.$plainTextToken);
    }


    public function tokenCan(string $ability):bool{
        return true;
    }

    public function findByUserByToken(string $token, string $class):?User
       {

        /**
         * @var \App\Entity\AccessToken
         */
        $accesstoken = $this->accessTokenRepository->findOneBy(['token'=>$token]);
        return $accesstoken->getTokenable();
       }
    
}
