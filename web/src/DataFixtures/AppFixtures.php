<?php

namespace App\DataFixtures;

use App\Entity\Watch;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // create 20 products! Bam!
        for ($i = 0; $i < 20; $i++) {
            $watch = new Watch();
            $watch->setTitle('watch ' . $i);
            $watch->setPrice(mt_rand(10, 100));
            $watch->setDescription("Super watch " . $i);
            $manager->persist($watch);
        }

        $manager->flush();
    }
}