<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Program;

use Faker\Factory;


class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const PROGRAMLIST=[
        [
            "Title" => "Wednesday",
            "Synopsys" => "A présent étudiante à la singulière Nevermore Academy, Wednesday Addams tente de s'adapter
             auprès des autres élèves tout en enquêtant à la suite d'une série de meurtres qui terrorise la ville...",
            "Category" => "category_Fantastique",
            "country" => "USA",
            "year" => "2022"
        ],
        [
            "Title" => "OSS 117",
            "Synopsys" => " Le Président de la République Française, Monsieur René Coty, envoie son arme maîtresse
             mettre de l'ordre dans cette pétaudière au bord du chaos : Hubert Bonisseur de la Bath, dit OSS 117",
            "Category" => "category_Comédie",
            "country" => "France",
            "year" => "2010"
        ],
        [
            "Title" => "Le Seigneur des Anneaux",
            "Synopsys" => " Les armées de Sauron ont attaqué Minas Tirith, la capitale de Gondor. Jamais ce royaume 
            autrefois puissant n'a eu autant besoin de son roi. Mais Aragorn trouvera-t-il en lui la volonté d'accomplir sa destinée ?",
            "Category" => "category_Aventure",
            "country" => "Angleterre",
            "year" => "2004"
        ],
        [
            "Title" => "Conjuring : Les dossiers de Warren",
            "Synopsys" => " Avant Amityville, il y avait Harrisville… Conjuring : Les dossiers Warren, raconte
            l'histoire horrible, mais vraie, d'Ed et Lorraine Warren, enquêteurs paranormaux réputés dans le
            monde entier, venus en aide à une famille terrorisée par une présence inquiétante
            dans leur ferme isolée… ",
            "Category" => "category_Horreur",
            "country" => "USA",
            "year" => "2012"
        ],
        [
            "Title" => "Walking Dead",
            "Synopsys" => " Des zombies envahissent la terre ",
            "Category" => "category_Action",
            "country" => "USA",
            "year" => "2010"
        ]
    ];

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        foreach(self::PROGRAMLIST as $key => $ProgramInfo) {
            $program = new Program();
        $program->setTitle($ProgramInfo['Title']);
        $program->setSynopsys($ProgramInfo['Synopsys']);
        $program->setYear($faker->year());
        $program->setCountry($faker->country());
        $program->setCategory($this->getReference($ProgramInfo["Category"]));
        $this->addReference( 'program_' . $key , $program);

        $manager->persist($program);
        }
        $manager->flush();
    }



    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            CategoryFixtures::class,
        ];
    }


}