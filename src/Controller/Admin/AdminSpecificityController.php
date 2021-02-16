<?php

namespace App\Controller\Admin;

use App\Entity\Specificity;
use App\Form\SpecificityType;
use Doctrine\ORM\EntityManager;
use App\Repository\SpecificityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Componenté\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminSpecificityController extends AbstractController
{
    /**
     *
     * @var SpecificityRepository
     */

    private $repository;
    protected $em;

    public function __construct(SpecificityRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/specificitys", name="admin.specificity.index")
     */
    public function index()
    {
        // Get all Specificitys objects from DB
        $spcificities = $this->repository->findAll();

        // send specificity in our index view
        return $this->render('admin/specificity/index.html.twig', compact('specificitys'));
    }

    /**
     * @Route("/admin/specificity/{id}/edit/", name="admin.specificity.edit", methods="GET|POST")
     * @Route("/admin/specificity/create/", name="admin.specificity.create", methods="GET|POST")
     */
    public function createEdit(Specificity $specifity = null, Request $request)
    {
        if (!$specifity) {
            $specifity = new Specificity;
            $statue = 'crée';
        } else {
            $statue = 'édité';
        }
        // Utiliser une instance du formaulaire de Property avec les valeur de $spcificities 
        $form = $this->createForm(SpecificityType::class, $specifity);

        // Gérer la requête
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // persist to the DB 

            $this->em->persist($specifity);

            // Write into DB
            $this->em->flush();

            // Success Message

            $this->addFlash("sucess", "Le bien a bien été $statue");

            return $this->redirectToRoute('admin.specificity.index', [], 301);
        }

        // Formulaire à envoyer à la vue
        $form = $form->createView();


        $currentRoute = $request->attributes->get('_route');

        // En fonction de la route , envoyer la vue edition ou creation

        if ($currentRoute == 'admin.specificity.create') {
            return $this->render('admin/specificity/create.html.twig', ['property' => $specifity, 'form' => $form]);
        } else {
            return $this->render('admin/specificity/edite.html.twig', ['property' => $specifity, 'form' => $form]);
        }
    }

    /**
     * @Route("/admin/specificity/{id}/delete/", name="admin.specificity.delete")
     */
    public function delete(Specificity $specifity)
    {
        // Déclarer la suppression à l'entity manager
        $this->em->remove($specifity);

        // Supprimer de la base de donnée
        $this->em->flush();

        $this->addFlash("sucess", "Le bien a bien été supprimé");


        // Redirect to home page | Admin page
        return $this->redirectToRoute('admin.specificity.index', [], 301);
    }
}
