<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/biens", )
 */
class PropertyController extends AbstractController
{
    /**
     * @Route("/", name="property.index")
     */
    public function index(): Response
    {
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
        ]);
    }
}
