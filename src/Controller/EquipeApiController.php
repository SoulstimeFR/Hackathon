<?php

namespace App\Controller;

use App\Repository\EquipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/equipes', name: 'api_equipe_')]
class EquipeApiController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(EquipeRepository $repository): JsonResponse
    {
        return $this->json($repository->findAll(), context: ['groups' => 'equipe:read']);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\\d+'], methods: ['GET'])]
    public function show(int $id, EquipeRepository $repository): JsonResponse
    {
        $equipe = $repository->find($id);

        if (null === $equipe) {
            return $this->json(['error' => 'Équipe introuvable'], 404);
        }

        return $this->json($equipe, context: ['groups' => 'equipe:read']);
    }
}
