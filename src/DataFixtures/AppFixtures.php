<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $em)
    {
        // Creat a now Property

        // Set values to our Property
        // /!\Creat_at and sold are set at the creation by default in the constructor /!\
        for ($i = 0; $i < 10; $i++) {
            $property = new Property;
            $property->setTitle('Mon premier bien')
                ->setPrice(200000)
                ->setRooms(4)
                ->setBedrooms(3)
                ->setDescription('Une petite description')
                ->setSurface(60)
                ->setFloor(4)
                ->setHeat(1) // 0 Electric , 1 Gaz
                ->setAddress('40 Avenue du Rhin')
                ->setCity('Strasbourg')
                ->setPostaleCode(67000)
                ->setSold(false);

            // Persist Property in database
            $em->persist($property);

            // Send data to the DB
            $em->flush();
        }

        for ($i = 0; $i < 1; $i++) {
            $property = new Property;
            $property->setTitle('Mon premier bien VENDU')
                ->setPrice(200000)
                ->setRooms(4)
                ->setBedrooms(3)
                ->setDescription('Une petite description')
                ->setSurface(60)
                ->setFloor(4)
                ->setHeat(1) // 0 Electric , 1 Gaz
                ->setAddress('40 Avenue du Rhin')
                ->setCity('Strasbourg')
                ->setPostaleCode(67000)
                ->setSold(true);

            // Persist Property in database
            $em->persist($property);

            // Send data to the DB
            $em->flush();
        }
    }
}
