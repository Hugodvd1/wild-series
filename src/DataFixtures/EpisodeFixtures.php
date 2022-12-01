<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

//Tout d'abord nous ajoutons la classe Factory de FakerPhp
use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for($i = 0; $i < 10; $i++) {
            $episode = new Episode();
            $episode->setTitle($faker->title());
            $episode->setNumber($faker->numberBetween(1, 10));
            $episode->setSynopsys($faker->paragraphs(3, true));
            $this->addReference('episode_' . $i, $episode);
            $episode->setSeason($this->getReference('season_' . $faker->numberBetween(0, 50)));

            $manager->persist($episode);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SeasonFixtures::class,
        ];
    }
}