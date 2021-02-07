<?php

namespace App\Controller\Admin;

use App\Entity\Option;
use App\Form\OptionType;
use Doctrine\ORM\EntityManager;
use App\Repository\OptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Componenté\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminOptionController extends AbstractController
{
    /**
     *
     * @var OptionRepository
     */

    private $repository;
    protected $em;

    public function __construct(OptionRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/options", name="admin.option.index")
     */
    public function index()
    {
        // Get all Options objects from DB
        $options = $this->repository->findAll();

        // send option in our index view
        return $this->render('admin/option/index.html.twig', compact('options'));
    }

    /**
     * @Route("/admin/option/{id}/edit/", name="admin.option.edit", methods="GET|POST")
     * @Route("/admin/option/create/", name="admin.option.create", methods="GET|POST")
     */
    public function createEdit(Option $option = null, Request $request)
    {
        if (!$option) {
            $option = new Option;
            $statue = 'crée';
        } else {
            $statue = 'édité';
        }
        // Utiliser une instance du formaulaire de Property avec les valeur de $options 
        $form = $this->createForm(OptionType::class, $option);

        // Gérer la requête
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // persist to the DB 

            $this->em->persist($option);

            // Write into DB
            $this->em->flush();

            // Success Message

            $this->addFlash("sucess", "Le bien a bien été $statue");

            return $this->redirectToRoute('admin.option.index', [], 301);
        }

        // Formulaire à envoyer à la vue
        $form = $form->createView();


        $currentRoute = $request->attributes->get('_route');

        // En fonction de la route , envoyer la vue edition ou creation

        if ($currentRoute == 'admin.option.create') {
            return $this->render('admin/option/create.html.twig', ['property' => $option, 'form' => $form]);
        } else {
            return $this->render('admin/option/edite.html.twig', ['property' => $option, 'form' => $form]);
        }
    }

    /**
     * @Route("/admin/option/{id}/delete/", name="admin.option.delete")
     */
    public function delete(Option $option)
    {
        // Déclarer la suppression à l'entity manager
        $this->em->remove($option);

        // Supprimer de la base de donnée
        $this->em->flush();

        $this->addFlash("sucess", "Le bien a bien été supprimé");


        // Redirect to home page | Admin page
        return $this->redirectToRoute('admin.option.index', [], 301);
    }
}
