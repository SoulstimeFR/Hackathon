<?php

namespace App\Controller;

use App\Repository\HackathonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/hackathons', name: 'api_hackathon_')]
class HackathonApiController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(HackathonRepository $repository): JsonResponse
    {
        return $this->json($repository->findAll(), context: ['groups' => 'hackathon:read']);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\\d+'], methods: ['GET'])]
    public function show(int $id, HackathonRepository $repository): JsonResponse
    {
        $hackathon = $repository->find($id);

        if (null === $hackathon) {
            return $this->json(['error' => 'Hackathon introuvable'], 404);
        }

        return $this->json($hackathon, context: ['groups' => 'hackathon:read']);
    }
}
