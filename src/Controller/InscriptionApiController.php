<?php

namespace App\Controller;

use App\Repository\InscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/inscriptions', name: 'api_inscription_')]
class InscriptionApiController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(InscriptionRepository $repository): JsonResponse
    {
        return $this->json($repository->findAll(), context: ['groups' => 'inscription:read']);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\\d+'], methods: ['GET'])]
    public function show(int $id, InscriptionRepository $repository): JsonResponse
    {
        $inscription = $repository->find($id);

        if (null === $inscription) {
            return $this->json(['error' => 'Inscription introuvable'], 404);
        }

        return $this->json($inscription, context: ['groups' => 'inscription:read']);
    }
}
