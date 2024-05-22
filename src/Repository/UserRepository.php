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
        //$token->setTokenableType(User::class);
        $token->setToken(hash('sha256', $plainTextToken=ByteString::fromRandom(40)));

        //$token->setUser($entity);
        //$user->addToken($token);
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
        $em = $this->getEntityManager();



        $rsm = new ResultSetMappingBuilder($em);
        $rsm->addRootEntityFromClassMetadata('App\Entity\User', 'u',['id'=>'id','username'=>'username']);
        //$rsm->addJoinedEntityFromClassMetadata('App\Entity\AccessToken', 'a', 'u', 'access_token', array('id' => 'access_token_id','expired_at'=>'expired_at'));

        //$rsm = new ResultSetMapping;

        /* $rsm->addEntityResult('App\Entity\User', 'u');
        $rsm->addFieldResult('u', 'id', 'id');
        $rsm->addFieldResult('u', 'username', 'username');
        $rsm->addJoinedEntityResult('App\Entity\AccessToken' , 'a', 'u', 'access_token');
        $rsm->addFieldResult('a', 'access_token_id', 'id');
        $rsm->addFieldResult('a', 'expired_at', 'expired_at'); */
        //$rsm->addFieldResult('a', 'city', 'city');

        $sql ='SELECT u.id, u.username, a.id as access_token_id, a.expired_at FROM user u INNER JOIN access_token a on u.id = a.tokenable_id 
        WHERE a.token =?';
            //and a.tokenable_type = ?
        $q = $em->createNativeQuery($sql,$rsm)
        ->setParameter(1,$token)
        //->setParameter(2,$token)
        ->execute();


        /**
         * @var \App\Entity\AccessToken
         */
        $accesstoken = $this->accessTokenRepository->findOneBy(['token'=>$token, 'tokenable_type'=>$class]);
        /**
         * @var \App\Entity\User
         */
        $user= $this->find($accesstoken->getId());
        //$user->setAccessToken($accesstoken);
        return $user;
       }
    

    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?User
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
