<?php

namespace App\DataFixtures;

use App\Entity\Actor as EntityActor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public const ACTORS = [
        [
            "name" => 'Alain Melon', 'Catherien Doccasion', 'Henri Dark Vador', 'Jim Pas carrey ', 'Morgan Not Free Man',
            
        ],
    ];
    public static int $actorNumber = 0;

    public function load(ObjectManager $manager): void
    {
  
        $faker = Factory::create();
        for ($j = 0; $j < ProgramFixtures::$programNumber; $j++) {
            for ($i = 0; $i < 3; $i++) {
                $actor = new EntityActor();
                $actor->setName($faker->name());
                $actor->addProgram($this->getReference('program_' . $j));
                $manager->persist($actor);
                self::$actorNumber++;
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

