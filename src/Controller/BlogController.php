<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * 
     * TODO: CREER LES CATÉGORIES 
     * TODO: CREER LES ARTICLES
     * 
     * TODO: AFFICHER LES LISTE DES CATÉGORIES
     * TODO: AFFICHER LES LISTE DES CATÉGORIES
     * TODO: AFFICHER LA LISTE DES ARTICLES
     * @return Response
     */

    /**
     * @Route("/blog", name="blog")
     */
    public function index(CategoryRepository $repository): Response
    {
        $categories = $repository->findAll();

        return $this->render('blog/index.html.twig', [
            'categories' => $categories,
        ]);
    }
}
