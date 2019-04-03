<?php

namespace App\DataFixtures;

use App\Entity\Roles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class RolesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $roleSuperAdmin = new Roles();
        $roleSuperAdmin->setName('ROLE_SUPER_ADMIN');
        $roleSuperAdmin->setDescription('You can do whatever you want');
        // $roleSuperAdmin->addUser($this->getReference('user_1'));

        $roleAdmin = new Roles();
        $roleAdmin->setName('ROLE_ADMIN');
        $roleAdmin->setDescription('You can manage users');
        // $roleAdmin->addUser($this->getReference('user_2'));

        $roleUser = new Roles();
        $roleUser->setName('ROLE_USER');
        $roleUser->setDescription('Just work');
        // $roleUser->addUser($this->getReference('user_3'));
        // $roleUser->addUser($this->getReference('user_4'));

        $manager->persist($roleSuperAdmin);
        $manager->persist($roleAdmin);
        $manager->persist($roleUser);

        $manager->flush();
    }
}