<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture{
    public function load(ObjectManager $manager){
        $user = new User();
        $user->setEmail('nathan@test.com');

        $hash = password_hash('testtest', PASSWORD_BCRYPT);

        $user->setPassword($hash);
        $user->setRoles(['ROLE_USER', 'ROLE_CHASSEUR']);
        $user->setPhone('0606060606');
        $user->setName('Nathan');
        $user->setSurname('Metzger');
        $user->setAddress('1 rue de la paix');
        $user->setUsername('nathanmetzger');
        $user->setDateDeNaissance(new \DateTime('1999-01-01'));
        $manager->persist($user);
    
        $manager->flush();
    }
}