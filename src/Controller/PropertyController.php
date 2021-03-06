<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Property;
use App\Form\PropertyType;
use App\Entity\PropertySearch;
use App\Form\ContactType;
use App\Form\PropertySearchType;
use App\Notification\ContactNotification;
use App\Repository\PropertyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
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
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new PropertySearch();
        // Il faut utiliser le type PropertySearchType pour créer notre formulaire
        $form = $this->createForm(PropertySearchType::class, $search);
        // Gérer la requête
        $form->handleRequest($request);


        // Get all not solded properties ( all availables ) with paginator
        $properties = $paginator->paginate(
            $this->em->findAllAvailableQuery($search),
            $request->query->getInt('page', 1), /*page number*/
            12
        );

        // Send properties to the view
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $properties,
            'formSearch' => $form->createView()
        ]);
    }

    /**
     * @Route("/bien/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     */

    public function show(Property $property, string $slug, Request $request, ContactNotification $notification): Response
    {

        if ($property->getSlug() !== $slug) {
            $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug(),
            ], 301);
        }

        // Form contact
        $contact = new Contact();
        $contact->setProperty($property);

        $formContact = $this->createForm(ContactType::class, $contact);
        $formContact->handleRequest($request);

        if ($formContact->isSubmitted() && $formContact->isValid()) {

            // Send an email to our contact
            $notification->notify($contact);
            $this->addFlash('success', 'Votre email a bien été envoyé');
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ]);
        }

        // Send property to the view
        return $this->render('property/show.html.twig', [
            'current_menu' => 'properties',
            'property' => $property,
            'formContact' => $formContact->createView(),
        ]);
    }
}
