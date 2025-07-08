<?php

namespace App\Controller;

use App\Repository\HistoriqueRepository;
use App\Service\HistoriqueService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class HistoriqueController extends AbstractController
{
    #[Route('/historique', name: 'historique-all')]
    public function index(HistoriqueService $historiqueService, HistoriqueRepository $historiqueRepository): JsonResponse
    {
        $historiques = $historiqueService->findAll($historiqueRepository);
        //TODO: Use a Serializer instead
        $historiques = array_map(fn($historique) => [
                'id' => $historique->getId(),
                'coffre' => [
                    'id' => $historique->getCoffre()->getId(),
                    'name' => $historique->getCoffre()->getName(),
                ],
                'user' => [
                    'id'=> $historique->getUser()->getId(),
                    'username'=> $historique->getUser()->getUsername(),
                ],
                'code' => [
                    'id'=> $historique->getCode()->getId(),
                    'code'=> $historique->getCode()->getCode(),
                ]
            ], $historiques);
        return $this->json($historiques);
    }
}
