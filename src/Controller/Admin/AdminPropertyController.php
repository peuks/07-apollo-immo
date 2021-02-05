<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use Doctrine\ORM\EntityManager;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Componenté\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPropertyController extends AbstractController
{
    /**
     *
     * @var PropertyRepository
     */

    private $repository;
    protected $em;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/properties", name="admin.property.index")
     * @Route("/admin/", name="admin.property.index")
     */
    public function index()
    {
        // Get all Properties objects from DB
        $properties = $this->repository->findAll();

        // Inject property in our index view
        return $this->render('admin/property/index.html.twig', compact('properties'));
    }

    /**
     * @Route("/admin/property/{id}/edit/", name="admin.property.edit", methods="GET|POST")
     * @Route("/admin/property/create/", name="admin.property.create", methods="GET|POST")
     */
    public function createEdit(Property $property = null, Request $request)
    {
        if (!$property) {
            $property = new Property;
            $statue = 'crée';
        } else {
            $statue = 'édité';
        }
        // Utiliser une instance du formaulaire de Property avec les valeur de $property 
        $form = $this->createForm(PropertyType::class, $property);

        // Gérer la requête
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Set slug
            $property->setSlug($property->getTitle());

            // persist to the DB 

            $this->em->persist($property);

            // Write into DB
            $this->em->flush();

            // Success Message

            $this->addFlash("sucess", "Le bien a bien été $statue");

            return $this->redirectToRoute('admin.property.index', [], 301);
        }


        // Formulaire à envoyer à la vue
        $form = $form->createView();


        $currentRoute = $request->attributes->get('_route');

        // En fonction de la route , envoyer la vue edition ou creation

        if ($currentRoute == 'admin.property.create') {
            return $this->render('admin/property/create.html.twig', ['property' => $property, 'form' => $form]);
        } else {
            return $this->render('admin/property/edite.html.twig', ['property' => $property, 'form' => $form]);
        }
    }

    /**
     * @Route("/admin/property/{id}/delete/", name="admin.property.delete")
     */
    public function delete(Property $property)
    {
        // Déclarer la suppression à l'entity manager
        $this->em->remove($property);

        // Supprimer de la base de donnée
        $this->em->flush();

        $this->addFlash("sucess", "Le bien a bien été supprimé");


        // Redirect to home page | Admin page
        return $this->redirectToRoute('admin.property.index', [], 301);
    }
}
