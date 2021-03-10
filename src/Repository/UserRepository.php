<?php

namespace App\Repository;

use App\Entity\User;
use App\Services\Mailer\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Provider\FacebookUser;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,MailerService $mailer,UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        $this->mailer = $mailer;
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

            $password = "AKCZZ2603";
            /*$password = substr(strtoupper(md5(date('Y-m-d h:i:s'))),0,-15);*/

            $user = (new User)
            ->setEmail($googleUser->getEmail())
            ->setFirstName($googleUser->getFirstName())
            ->setLastName($googleUser->getLastName())
            ->setPicture($googleUser->getAvatar());

            $user->setPassword($this->encoder->encodePassword($user,$password));

            $manager = $this->getEntityManager();
            $manager->persist($user);
            $manager->flush();


            /*$this->mailer->sendEmailAfterOauth($googleUser->getEmail(),$googleUser->getFirstName(),$password);*/

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

            /*$password = substr(strtoupper(md5(date('Y-m-d h:i:s'))),0,-15);*/

            $password = "AKCZZ2603";

            $user = (new User)
            ->setEmail($facebookUser->getEmail())
            ->setFirstName($facebookUser->getFirstName())
            ->setLastName($facebookUser->getLastName())
            ->setPicture($facebookUser->getPictureUrl());
            
            $user->setPassword($this->encoder->encodePassword($user,$password));
            
            $manager = $this->getEntityManager();
            $manager->persist($user);
            $manager->flush();
            
            /*$this->mailer->sendEmailAfterOauth($facebookUser->getEmail(),$facebookUser->getFirstName(),$password);*/

            return $user;
    } 

}
