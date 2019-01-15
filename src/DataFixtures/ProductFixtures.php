<?php

namespace App\DataFixtures;

use App\Entity\Collection;
use App\Entity\Product;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $slugify = new Slugify();

        $repository = $manager->getRepository(Collection::class);
        $collections = $repository->findAll();

        for($i = 0; $i<50; $i++) {
            $faker = Factory::create('fr_FR');

            $product = new Product();
            $product->setName(ucwords($faker->word));
            $product->setPrice(rand(10, 100));
            $product->setSKU($faker->swiftBicNumber);
            $product->setSlug($slugify->slugify($faker->word));
            $product->setPictureUrl($faker->imageUrl(1920, 570, 'transport'));
            $product->setDateAdd(new \DateTime());
            $product->setCollectionId($collections[rand(0, (count($collections) - 1))]);

            $manager->persist($product);
        }

        $manager->flush();
    }
}
