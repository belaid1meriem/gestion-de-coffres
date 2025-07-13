<?php

namespace App\Controller;

use App\Entity\Vault;
use App\Service\HistoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/api')]
/**
 * Controller responsible for handling history-related API endpoints.
 */
final class HistoryController extends AbstractController
{
    /**
     * @param HistoryService $historyService The service responsible for fetching vault history.
     */
    public function __construct(
        private HistoryService $historyService,
    ) {}

    /**
     * Retrieves the history records associated with a given vault.
     *
     * @param Vault $vault The vault entity whose history is being retrieved.
     *
     * @return JsonResponse The JSON response containing the vault history.
     */
    #[Route('/history/{vault}', name: 'history.all', methods: ['GET'])]
    public function getHistoryByVault(Vault $vault): JsonResponse
    {
        $history = $this->historyService->getHistoryByVault($vault);

        return $this->json($history);
    }
}
