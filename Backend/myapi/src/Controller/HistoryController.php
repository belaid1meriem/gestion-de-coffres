<?php

namespace App\Controller;

use App\Service\HistoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/api')]

final class HistoryController extends AbstractController
{
    public function __construct(
    private HistoryService $historyService, 
    ) {}

    #[Route('/history/{id}', name: 'history.all', methods:['GET'])]
    public function getHistoryByVault(int $id): JsonResponse
    {
        $history = $this->historyService->getHistoryByVault($id);

        return $this->json($history);
    }
}
