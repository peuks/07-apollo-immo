<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/biens", )
 */
class PropertyController extends AbstractController
{
    /**
     * @Route("/", name="property.index")
     */
    public function index(PropertyRepository $propertyRepository): Response
    {
        // Get all not solded properties
        $properties = $propertyRepository->findAllAvailable("false");

        // Send properties to the view
        return $this->render('property/index.html.twig', [
            'properties' => $properties,
        ]);
    }
}
