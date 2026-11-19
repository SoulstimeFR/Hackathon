<?php

namespace App\Controller;

use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/projets', name: 'api_projet_')]
class ProjetApiController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(ProjetRepository $repository): JsonResponse
    {
        return $this->json($repository->findAll(), context: ['groups' => 'projet:read']);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\\d+'], methods: ['GET'])]
    public function show(int $id, ProjetRepository $repository): JsonResponse
    {
        $projet = $repository->find($id);

        if (null === $projet) {
            return $this->json(['error' => 'Projet introuvable'], 404);
        }

        return $this->json($projet, context: ['groups' => 'projet:read']);
    }
}
