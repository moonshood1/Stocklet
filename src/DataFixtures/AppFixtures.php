<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);


        $loulou = new User();   
        $loulou->setFirstName('Louis Roger')
             ->setLastName('Guirika')
             ->setEmail('louisroger@live.fr')
             ->setPassword($this->encoder->encodePassword($loulou,'12345678'))
             ->setAddress('Deux plateaux Duncan Apres CEI')
             ->setUserPhone('08990169')
             ->addUserRole($adminRole);

             $manager->persist($loulou);
    

        $manager->flush();
    }
}
