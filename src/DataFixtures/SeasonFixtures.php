<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

//Tout d'abord nous ajoutons la classe Factory de FakerPhp
use Faker\Factory;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public static int $seasonNumber = 0;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($j=0; $j<ProgramFixtures::$programNumber; $j++) {
            for($i = 0; $i < 5; $i++) {
                $season = new Season();
                $season->setNumber($faker->numberBetween(1, 10));
                $season->setYear($faker->year());
                $season->setDescription($faker->paragraphs(3, true));
                $this->addReference('season_' . self::$seasonNumber, $season);
                $season->setProgram($this->getReference('program_' . $j));
    
                $manager->persist($season);
                self::$seasonNumber++;
            }
        }
        

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProgramFixtures::class,
        ];
    }
}