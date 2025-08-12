<?php
// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $em): void
    {
        $faker = Factory::create();

        // Categories
        $cats = [];
        foreach (['Fiction','Non-Fiction','Psychology','Self-Help','Medicine','CS'] as $name) {
            $c = (new Category())->setName($name)->setSlug(strtolower(str_replace(' ', '-', $name)));
            $em->persist($c);
            $cats[] = $c;
        }

        // Authors
        $authors = [];
        for ($i=0; $i<10; $i++) {
            $a = (new Author())
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setBio($faker->optional()->paragraph());
            $em->persist($a);
            $authors[] = $a;
        }

        // Books
        for ($i=0; $i<25; $i++) {
            $b = (new Book())
                ->setTitle($faker->sentence(3))
                ->setIsbn($faker->unique()->numerify('978##########'))
                ->setPages($faker->numberBetween(120, 650))
                ->setCategory($faker->randomElement($cats))
                ->setPublishedAt($faker->optional()->dateTimeBetween('-20 years', 'now') ? new \DateTimeImmutable($faker->date()) : null);

            // прикріпимо 1–3 авторів
            foreach ($faker->randomElements($authors, $faker->numberBetween(1,3)) as $a) {
                $b->addAuthor($a);
            }
            $em->persist($b);
        }

        $em->flush();
    }
}

