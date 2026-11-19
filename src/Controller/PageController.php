<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\HackathonRepository;
use App\Entity\Hackathon;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'root')]
    public function home(HackathonRepository $hackathonRepository): Response
    {
        return $this->render('page/root.html.twig', [
            'hackathons' => $hackathonRepository->findAll(),
        ]);
    }

    #[Route('/hackathons', name: 'hackathons')]
    public function hackathons(HackathonRepository $hackathonRepository): Response
    {
        return $this->render('page/hackathons.html.twig', [
            'hackathons' => $hackathonRepository->findAll(),
        ]);
    }

    #[Route('/hackathon/{id}', name: 'hackathons_show', requirements: ['id' => '\d+'])]
    public function show(Hackathon $hackathon): Response
    {
        return $this->render('page/hackathons_show.html.twig', [
            'hackathon' => $hackathon,
        ]);
    }

    #[Route('/equipes', name: 'equipes')]
    public function equipes(): Response
    {
        return $this->render('page/equipes.html.twig', [
            'email' => 'hello@example.com',
        ]);
    }
}
