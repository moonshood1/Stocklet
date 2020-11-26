<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use League\OAuth2\Client\Provider\FacebookUser;
use League\OAuth2\Client\Provider\GoogleUser;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

   

    public function findOrCreateFromGoogleOauth(GoogleUser $googleUser):User
    {
        $user = $this->createQueryBuilder('u')
            ->where('u.email = :googleEmail')
            ->setParameters(['googleEmail' => $googleUser->getEmail()])
            ->getQuery()
            ->getOneOrNullResult();


            if ($user) {return $user;};

            $user = (new User)->setEmail($googleUser->getEmail())
            ->setFirstName($googleUser->getFirstName())
            ->setLastName($googleUser->getLastName())
            ->setPicture($googleUser->getAvatar());

            $manager = $this->getEntityManager();
            $manager->persist($user);
            $manager->flush();

            return $user;
    }

    public function findOrCreateFromFacebookOauth(FacebookUser $facebookUser):User
    {
        $user = $this->createQueryBuilder('u')
            ->where('u.email = :facebookEmail')
            ->setParameters(['facebookEmail'=> $facebookUser->getEmail()])
            ->getQuery()
            ->getOneOrNullResult();

            if ($user) {return $user;};

            $user = (new User)->setEmail($facebookUser->getEmail())
            ->setFirstName($facebookUser->getFirstName())
            ->setLastName($facebookUser->getLastName())
            ->setPicture($facebookUser->getPictureUrl());

            $manager = $this->getEntityManager();
            $manager->persist($user);
            $manager->flush();

            return $user;
    } 

}