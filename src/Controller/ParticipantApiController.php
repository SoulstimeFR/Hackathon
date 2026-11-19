<?php

namespace App\Controller;

use App\Repository\ParticipantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/participants', name: 'api_participant_')]
class ParticipantApiController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(ParticipantRepository $repository): JsonResponse
    {
        return $this->json($repository->findAll(), context: ['groups' => 'participant:read']);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\\d+'], methods: ['GET'])]
    public function show(int $id, ParticipantRepository $repository): JsonResponse
    {
        $participant = $repository->find($id);

        if (null === $participant) {
            return $this->json(['error' => 'Participant introuvable'], 404);
        }

        return $this->json($participant, context: ['groups' => 'participant:read']);
    }
}
