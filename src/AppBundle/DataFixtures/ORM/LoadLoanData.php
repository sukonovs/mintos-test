<?php namespace AppBundle\DataFixtures\ORM;

/**
 * Load loan data
 *
 * @author Roberts Sukonovs <roberts.sukonovs@gmail.com>
 * @package AppBundle\DataFixtures\ORM
 */

use AppBundle\Entity\Loan;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Faker\Factory;

class LoadLoanData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 200; $i++) {
            $loan = new Loan();

            $amount = $faker->randomFloat(2, 10, 3000);

            $loan->setAmount($amount);
            $loan->setAvailableForInvestments($amount);
            $loan->setTitle($faker->company);

            $manager->persist($loan);
        }

        $manager->flush();
    }
}