<?php

namespace App\Controller;

use App\Repository\HackathonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HackathonController extends AbstractController
{
    #[Route('/hackathons', name: 'app_hackathon_index', methods: ['GET'])]
    public function index(HackathonRepository $hackathonRepository): Response
    {
        return $this->render('hackathon/index.html.twig', [
            'hackathons' => $hackathonRepository->findAll(),
        ]);
    }
}
