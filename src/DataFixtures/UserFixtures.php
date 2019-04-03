<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 20; ++$i) {
            $user = new User();
            $user->setUsername('jonsnow_'.$i);
            $user->setIsActive(0 == $i % 2 ? false : true);
            $manager->persist($user);
            $this->addReference('user_'.$i, $user);
        }

        $manager->flush();
    }
}