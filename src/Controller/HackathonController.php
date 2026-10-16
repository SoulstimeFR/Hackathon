<?php

namespace App\Controller;

use App\Repository\HackathonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    #[Route('/api/hackathons', name: 'app_hackathon_api', methods: ['GET'])]
    public function api(HackathonRepository $hackathonRepository): JsonResponse
    {
        $data = array_map(static fn ($h) => [
            'id' => $h->getId(),
            'theme' => $h->getTheme(),
            'lieu' => $h->getLieu(),
            'ville' => $h->getVille(),
            'dateHeureDebut' => $h->getDateHeureDebut()?->format('Y-m-d H:i:s'),
            'dateHeureFin' => $h->getDateHeureFin()?->format('Y-m-d H:i:s'),
        ], $hackathonRepository->findAll());

        return $this->json($data);
    }
}
