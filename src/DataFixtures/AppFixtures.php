<?php

namespace App\DataFixtures;

use App\Entity\Heat;
use App\Entity\Property;
use Cocur\Slugify\Slugify;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $em)
    {
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
            $em->persist($heatObject);
        }

        // ------------------------------------------------------------ \\
        // ------------------------Creat Properties --------------------\\
        // ------------------------------------------------------------- \\

        // Properties Names' Array 
        $properties = ['Property1', 'Property2', 'Property3'];

        foreach ($properties as $property) {
            $property = new Property;
            $property->setTitle("Mon premier bien")
                ->setPrice(mt_rand(80000, 580000))
                ->setRooms(4)
                ->setBedrooms(3)
                ->setDescription('Une petite description')
                ->setSurface(mt_rand(15, 400))
                ->setFloor(4)
                ->setAddress('40 Avenue du Rhin')
                ->setCity('Strasbourg')
                ->setPostaleCode(67000)
                ->setSold(false)

                // Slugs are based on Property's Title
                ->setSlug((new Slugify())->slugify($property->getTitle()));

            // Add current property to the $PropertiesArray
            $PropertiesArray[] = $property;

            // ------------------------------------------------------------ \\
            // ------------------------Seat Heat ------ --------------------\\
            // ------------------------------------------------------------- \\

            // Select a type of heat
            $currentHeat = array_rand($heatTypeArray);

            // Assign current  property to current heat
            $heatTypeArray[$currentHeat]->addProperty($property);

            $em->persist($property);
        }
        $em->flush();
    }
}
