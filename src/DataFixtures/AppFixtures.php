<?php

namespace App\DataFixtures;

use App\Entity\{User, Article, Category};
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create('fr_FR');

        $users = [];
        $categories = [];
        $articles = [];

        for ($i=0; $i < 20; $i++) { 
            $user = (new User())
                    ->setNameUser($faker->lastName())
                    ->setFirstnameUser($faker->firstName())
                    ->setEmailUser($faker->unique()->email())
                    ->setPasswordUser($faker->password(10, 100))
                    ->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($user);
            $users[] = $user;
        }

        for ($i=0; $i < 10; $i++) { 
            $category = (new Category())
                    ->setNameCat($faker->word())
                    ->setDescriptionCat($faker->text(200));

            $manager->persist($category);
            $categories[] = $category;
        }

        for ($i=0; $i < 100; $i++) { 
            $article = (new Article())
                    ->setTitleArticle($faker->text(20))
                    ->setContentArticle($faker->text(300))
                    ->setImageArticle($faker->imageUrl())
                    ->setCreatedAt(new \DateTimeImmutable())
                    ->setWriteBy($users[rand(0, (count($users)-1))])
                    ->addCategory($categories[rand(0, (count($categories)-1))]);
                    
            $manager->persist($article);
        }

        $manager->flush();
    }
}
