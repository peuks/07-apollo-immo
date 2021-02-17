<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Faker\Factory;
use App\Entity\Heat;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Specificity;
use App\Entity\Property;
use Cocur\Slugify\Slugify;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    protected  $encoder, $faker;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        $this->faker = Factory::create("fr_FR");
    }
    public function load(ObjectManager $manager)
    {
        // ------------------------------------------------------------ \\
        // ----------------------------------Initialize ADMIN ----------\\
        // ------------------------------------------------------------- \\        

        $admin = new User();
        $admin->setEmail("admin@admin.com")
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->encoder->encodePassword($admin, 'password'));
        // persis admin
        $manager->persist($admin);
        // ------------------------------------------------------------ \\
        // ----------------------------------Initialize USER -----------\\
        // ------------------------------------------------------------- \\        
        $users = [];
        $user = new User();
        $user->setEmail("user@user.com")
            ->setRoles(['ROLE_USER'])
            ->setFirstName($this->faker->firstName())
            ->setLastName($this->faker->lastName())
            ->setPassword($this->encoder->encodePassword($user, 'password'));

        /** @var User */
        $users[] = $user;
        // persis user
        $manager->persist($user);

        // ------------------------------------------------------------ \\
        // ----------------------------------Initialize FAKER ----------\\
        // ------------------------------------------------------------- \\        

        $faker = Factory::create('fr_FR');

        // ------------------------------------------------------------ \\
        // ----------------------------------Creat Heat Type -----------\\
        // ------------------------------------------------------------- \\

        // Heat TypeName
        $heats = ['Electrique', 'Gas', 'Fioul'];

        // Store heatType's Objects
        $heatTypeArray = [];


        // Set all heat's types

        foreach ($heats as $heatType) {

            $heatObject = new Heat;
            $heatObject->setType($heatType);
            // Add the heatTypeObject to the $heatTypeArray
            $heatTypeArray[] = $heatObject;

            // Persist current heat to DB
            $manager->persist($heatObject);
        }

        // ------------------------------------------------------------ \\
        // ----------------------------------Initialize Options --------\\
        // ------------------------------------------------------------- \\
        $optionsType = ["Balcon", "Ascenseur", "Piscine"];

        $specificities = [];

        foreach ($optionsType as $i) {
            $specificity = new Specificity;
            $specificity->setName($i);

            // Add specificity to $specificities

            $specificities[] = $specificity;

            $manager->persist($specificity);
        }

        // ------------------------------------------------------------ \\
        // ------------------------Creat Properties --------------------\\
        // ------------------------------------------------------------- \\

        for ($i = 0; $i < mt_rand(2, 5); $i++) {
            $property = new Property;

            $property->setTitle($faker->words(3, true))
                // Slugs are based on Property's Title
                ->setSlug((new Slugify())->slugify($property->getTitle()))
                ->setDescription($faker->sentences(3, true))
                ->setSurface($faker->numberBetween(20, 450))
                ->setRooms($faker->numberBetween(2, 10))
                ->setBedrooms($faker->numberBetween(1, 9))
                ->setFloor($faker->numberBetween(0, 15))
                ->setPrice($faker->numberBetween(50000, 1000000))
                ->setCity($faker->city)
                ->setAddress($faker->address)
                ->setPostaleCode(((int) $faker->postcode))
                ->setSold(false);

            // ------------------------------------------------------------ \\
            // ------------------------Seat Heat ------ --------------------\\
            // ------------------------------------------------------------- \\

            // Select a random type of heat between Electrique, Gas and Fioul
            $currentHeat = array_rand($heatTypeArray);

            // Assign current  property to current heat
            $heatTypeArray[$currentHeat]->addProperty($property);

            // ------------------------------------------------------------ \\
            // ------------------------Set Options ------------------------\\
            // ------------------------------------------------------------- \\
            $property->addSpecificity($faker->randomElement($specificities));

            // Persist $property
            $manager->persist($property);
        }


        // Création de 3 Agréments 

        // ------------------------------------------------------------ \\
        // ----------------------------------Initialize Catégories -----\\
        // ------------------------------------------------------------- \\        

        // Store heatType's Objects
        // $SpecificityArray = [];

        // for ($i = 0; $i < 3; $i++) {
        //     // Categories
        //     $specificity = new Specificity;
        //     $specificity->setName($faker->text(5));
        //     // Store actual sp$specificity in array
        //     $CategoriesArray[] = $specificity;
        //     // Persist actual sp$specificity
        //     $manager->persist($specificity);
        // }


        // ------------------------------------------------------------ \\
        // ----------------------------------Initialize Articles - -----\\
        // ------------------------------------------------------------- \\   
        // for ($i = 0; $i < mt_rand(2, 30); $i++) {
        //     $article = new Article;

        //     $article->setTitle($faker->word())
        //         ->setContent(implode("", $faker->words(10)));

        //     $manager->persist($article);

        //     // Select a random category 
        //     $currentCategory = $CategoriesArray[array_rand($CategoriesArray)];

        //     $article->addCategory($currentCategory);
        // }
        $manager->flush();
    }
}
