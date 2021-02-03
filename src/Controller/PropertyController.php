<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class PropertyController extends AbstractController
{
    private $em;
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
        // Get all not solded properties ( all availables )
        $properties = $this->em->findAllAvailable("false");

        // Send properties to the view
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $properties,
            // 'formSearch' => $form->createView()
        ]);
    }

    /**
     * @Route("/bien/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     */

    public function show(Property $property, string $slug): Response
    {
        if ($property->getSlug() !== $slug) {
            $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug(),
            ], 301);
        }
        // Send property to the view
        return $this->render('property/show.html.twig', [
            'current_menu' => 'properties',
            'property' => $property,
        ]);
    }
}
