<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Heat;
use App\Entity\User;
use App\Entity\Property;
use Cocur\Slugify\Slugify;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        // ------------------------------------------------------------ \\
        // ----------------------------------Initialize ADMIN ----------\\
        // ------------------------------------------------------------- \\        

        // Création d'un admin
        $admin = new User();
        $admin->setEmail("admin@gmail.com")
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->encoder->encodePassword($admin, 'password'));

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
        // ------------------------Creat Properties --------------------\\
        // ------------------------------------------------------------- \\

        for ($i = 0; $i < mt_rand(100, 300); $i++) {
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

            $manager->persist($property);
        }
        $manager->flush();
    }
}
