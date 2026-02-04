<?php

namespace App\DataFixtures;

use App\Entity\{User, Article, Category};
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function cleanStringForEmail(string $str): string
    {
        // 1. Convertir les caractères UTF-8 accentués en ASCII
        $str = iconv('UTF-8', 'ASCII//TRANSLIT', $str);

        // 2. Retirer tout ce qui n'est pas lettre ou chiffre
        $str = preg_replace('/[^a-zA-Z0-9]/', '', $str);

        // 3. Passer en minuscules
        return strtolower($str);
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $users = [];
        $categories = [];

        for ($i = 0; $i < 20; $i++) {
            // Créer l'email à partir des noms et prénoms précédemment générés
            $prenom = $faker->firstName();
            $nom = $faker->lastName();
            $domain = $faker->freeEmailDomain();
            $email = strtolower($this->cleanStringForEmail($prenom) . '.' . $this->cleanStringForEmail($nom) . '@' . $domain);

            $user = (new User())
                ->setNameUser($nom)
                ->setFirstnameUser($prenom)
                ->setEmailUser($email)
                ->setPasswordUser($faker->password(10, 100))
                ->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($user);
            $users[] = $user;
        }

        for ($i = 0; $i < 10; $i++) {
            $category = (new Category())
                ->setNameCat($faker->word())
                ->setDescriptionCat($faker->text(200));

            $manager->persist($category);
            $categories[] = $category;
        }

        for ($i = 0; $i < 100; $i++) {
            $article = (new Article())
                ->setTitleArticle($faker->text(20))
                ->setContentArticle($faker->text(300))
                ->setImageArticle($faker->imageUrl())
                ->setCreatedAt(new \DateTimeImmutable())
                ->setWriteBy($users[rand(0, (count($users) - 1))])
                ->setPublishedAt(new \DateTimeImmutable())
            // Choisir un nombre aléatoire de catégories (entre 1 et count($categories))
            $nbCategories = rand(1, count($categories));

            // Mélanger les catégories et prendre les premières $nbCategories
            $categoriesShuffled = $categories;
            shuffle($categoriesShuffled);
            $selectedCategories = array_slice($categoriesShuffled, 0, $nbCategories);

            // Ajouter les catégories à l'article
            foreach ($selectedCategories as $category) {
                $article->addCategory($category);
            }
            $manager->persist($article);
        }
        $manager->flush();
    }
}
