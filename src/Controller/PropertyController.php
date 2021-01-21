<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PropertyController extends AbstractController
{
    public function __construct(PropertyRepository $em)
    {
        // All functions from PropertyRepository will be accessibles with $this-> such find functions
        $this->em = $em;
    }

    /**
     * @Route("/biens", name="property.index")
     */
    public function index(): Response
    {
        // Get all not solded properties
        $properties = $this->em->findAllAvailable("false");

        // Send properties to the view
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $properties,
        ]);
    }

    /**
     * @Route("/bien/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     */

    public function show(Property $property, string $slug): Response
    {

        // Send property to the view
        return $this->render('property/show.html.twig', [
            'current_menu' => 'properties',
            'property' => $property,
        ]);
    }
}
