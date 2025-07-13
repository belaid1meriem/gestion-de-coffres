<?php

namespace App\Controller;


use App\Entity\Vault;
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

    #[Route('/history/{vault}', name: 'history.all', methods:['GET'])]
    public function getHistoryByVault(Vault $vault): JsonResponse
    {
        $history = $this->historyService->getHistoryByVault($vault);

        return $this->json($history);
    }
}
