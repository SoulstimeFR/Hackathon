<?php

namespace App\Controller;

use App\Repository\OrganisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/organisateurs', name: 'api_organisateur_')]
class OrganisateurApiController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(OrganisateurRepository $repository): JsonResponse
    {
        return $this->json($repository->findAll(), context: ['groups' => 'organisateur:read']);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\\d+'], methods: ['GET'])]
    public function show(int $id, OrganisateurRepository $repository): JsonResponse
    {
        $organisateur = $repository->find($id);

        if (null === $organisateur) {
            return $this->json(['error' => 'Organisateur introuvable'], 404);
        }

        return $this->json($organisateur, context: ['groups' => 'organisateur:read']);
    }
}
