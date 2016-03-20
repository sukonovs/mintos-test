<?php

namespace AppBundle\DataFixtures\ORM;

/**
 * Load user data
 *
 * @author Roberts Sukonovs <roberts.sukonovs@gmail.com>
 * @package AppBundle\DataFixtures\ORM
 */

use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Faker\Factory;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            
            $user->setUsername('investor_' . $i);
            $user->setPlainPassword('demo');
            $user->setEnabled(true);
            $user->setEmail(strtolower($faker->companyEmail));
            $user->setAvailableForInvestments($faker->randomFloat(2, 10, 100000));

            $manager->persist($user);
        }
        
        $manager->flush();
    }
}