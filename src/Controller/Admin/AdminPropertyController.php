<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Componenté\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController
{
    /**
     *
     * @var PropertyRepository
     */

    private $repository;

    public function __construct(PropertyRepository $em)
    {
        $this->repository = $em;
    }

    /**
     * @Route("/admin/properties", name="admin.property.index")
     */
    public function index()
    {
        // Get all Properties objects from DB
        $properties = $this->repository->findAll();

        // Inject property in our index view
        return $this->render('admin/property/index.html.twig', compact('properties'));
    }

    /**
     * @Route("/admin/property/{id}/edit/", name="admin.property.edit")
     */
    public function edit(Property $property)
    {

        return $this->render('admin/property/edit.html.twig', compact('property'));
    }

    /**
     * @Route("/admin/property/{id}/delete/", name="admin.property.delete")
     */
    public function delete(Property $property)
    {
        // Delete

        // Redirect to home page | Admin page
        return $this->redirectToRoute('admin.property.index');
    }
}
