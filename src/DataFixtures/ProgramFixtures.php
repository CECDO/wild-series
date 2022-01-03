<?php

namespace App\DataFixtures;

use App\Entity\Program;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS = [
        'Walking Dead',
        'The Witcher',
        'Peaky Blinders',
        'Sons of anarchy',
        'The It Crowd',
    ];

    private Slugify $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        foreach (self::PROGRAMS as $key => $programName) {
            $program = new Program();
            $program->setTitle($programName);
            $program->setSlug($this->slugify->generate($programName));
            $program->setSynopsis('Une super série');
            $program->setYear('2010');
            $program->setPoster('https://fr.web.img6.acsta.net/c_210_280/pictures/210/454/21045474_20130930201634487.jpg');
            $program->setCountry('USA');
            $program->setCategory($this->getReference('category_0'));
            for ($i=0; $i < count(ActorFixtures::ACTORS); $i++) {
                $program->addActor($this->getReference('actor_' . $i));
        }
        $this->addReference('program_' . $key, $program);
        $manager->persist($program);
    }
        $manager->flush();
    
    }

         public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          ActorFixtures::class,
          CategoryFixtures::class,
        ];
    }
}
