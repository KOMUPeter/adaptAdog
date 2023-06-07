<?php

namespace App\DataFixtures;

use App\Entity\Anoucement;
use App\Entity\Dog;
use App\Repository\AnoucementRepository;
use App\Repository\RaceRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DogFixtures extends Fixture implements DependentFixtureInterface
{
    protected RaceRepository $raceRepository;
    protected AnoucementRepository $anoucementRepository;

    public function __construct(RaceRepository $raceRepository, AnoucementRepository $anoucementRepository)
    {
        $this->raceRepository = $raceRepository;
        $this->anoucementRepository = $anoucementRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $dogsInfo = [
            [
                'name' => 'Mali',
                'background' => 'Mali est une chienne un peu timide, mais une fois sa confiance gagnée elle se révèle affectueuse et pot de colle',
                'description' => 'Il faudra une famille présente et prête à s\'investir dans son éducation.
                Nous recherchons pour Mali une famille sans autres animaux.
                Ok enfants respectueux.',
                'isLOF' => '1',
                'isTolerant' => '0'
            ],
            [
                'name' => 'Napoleon',
                'background' => 'Napoléon est un chien très touchant qui semble avoir vécu à l\'attache (il a une ancienne cicatrice qui fait tout le tour de son cou).',
                'description' => 'En laisse il reste réactif dès qu\'il voit un chien il aboie beaucoupmais en liberte il est sociable avec eux
                Napoléon est très mignon et se montre câlin avec les gens avec lesquels il est à l\'aise
                Il pourra être sage en intérieur
                Un placement non urbain sera idéal, en pavillon et sans jeunes enfants.
                on evitera un placement avec de nombreux escaliers et du sport',
                'isLOF' => '0',
                'isTolerant' => '0'
            ],
            [
                'name' => 'Boby',
                'background' => 'Boby étant encore un chiot dans sa tête, il est le roi des petites bêtises (jouer avec les couvertures par exemple).',
                'description' => 'Boby est un adorable épagneul, dynamique, très joueur et câlin. Boby adore jouer avec les autres chiens. Un copain chien dans le foyer serait donc le top.
                
                Boby aura besoin d\'une famille patiente, sportive et douce avec lui car il peut être craintif lorsqu\'il ne connait pas.
                
                Boby pourra vivre en maison ou en appartement avec des enfants dans le foyer.',
                'isLOF' => '1',
                'isTolerant' => '1'
            ],
            [
                'name' => 'Ninette',
                'background' => "Ninette est une gentille chienne, mais sur la réserve lorsqu'elle ne connait pas, il faudra donc du temps afin qu'elle soit en confiance, et elle a un souci de confiance envers les hommes dont elle se méfie davantage ...",
                'description' => "Elle se montre protectrice de son environnement.
                C'est une chienne qui aime les balades et les grands espaces, afin qu'elle se sente à l'aise, nous la placerons en maison et non en appartement. Elle aime jouer, et elle est gourmande.
                Elle n'est pas compatible avec les autres animaux.",
                'isLOF' => '1',
                'isTolerant' => '0'
            ],
        ];

        $races = $this->raceRepository->findAll();
        $anoucements = $this->anoucementRepository->findAll();

        foreach ($dogsInfo as $dogInfo) {
            $dog = new Dog();
            $dog->setName($dogInfo['name']);
            $dog->setBackground($dogInfo['background']);
            $dog->setDescription($dogInfo['description']);
            $dog->setIsLOF($dogInfo['isLOF']);
            $dog->setIsTolerant($dogInfo['isTolerant']);

            $nbRaces = 1;
            if (!$dog->getIsLOF()) {
                $nbRaces = mt_rand(1, 4);
            }

            for ($i = 1; $i <= $nbRaces; $i++) {
                $index = mt_rand(0, count($races) - 1);

                $dog->addRace($races[$index]);
            }

            $i = mt_rand(0, count($anoucements)-1);
            $dog->setAnoucement($anoucements[$i]);

            $manager->persist($dog);
        }
        $manager->flush();
    }


    public function getDependencies(): array
    {
        return [
            RaceFixtures::class,
            AnoucementFixtures::class,
        ];
    }
}