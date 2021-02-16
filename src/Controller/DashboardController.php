<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard', name: 'dashboard.')]

class DashboardController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', []);
    }

    #[Route('/account', name: 'account')]
    public function add(): Response
    {
        return $this->render('dashboard/account.html.twig', []);
    }

    #[Route('/apply', name: 'apply')]
    public function apply(): Response
    {
        return $this->render('dashboard/apply.index.html.twig', []);
    }

    #[Route('/dossier', name: 'dossier')]
    public function addDeposit(): Response
    {
        return $this->render('dashboard/dossier.index.html.twig', []);
    }
}
