<?php

namespace App\DataFixtures;

use App\Entity\Collection;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class CollectionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $slugify = new Slugify();
        for($i = 0; $i<5; $i++) {
            $faker = Factory::create('fr_FR');

            $collection = new Collection();
            $collection->setName(ucwords($faker->word));
            $collection->setSlug($slugify->slugify($faker->word));
            $collection->setPictureUrl($faker->imageUrl(1920, 570, 'cats'));
            $collection->setDateAdd(new \DateTime());

            $manager->persist($collection);
        }

        $manager->flush();
    }
}
