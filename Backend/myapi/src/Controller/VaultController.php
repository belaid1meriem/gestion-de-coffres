<?php

namespace App\Controller;

use App\Service\VaultService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class VaultController extends AbstractController
{
    public function __construct(
    private VaultService $vaultService, 
    ) {}

    #[Route('/vaults', name: 'vault.all', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $vaults = $this->vaultService->getVaults();

        return $this->json($vaults);
    }

    #[Route('/vault/create', name: 'vault.create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $vault = $this->vaultService->createVault($data['name'], $data['user']);

        return $this->json([
            'message' => 'Vault created successfully',
            'vault' => $vault,
        ], 201);
    }

    #[Route('/vault/edit/name/{id}', name: 'vault.editName', methods: ['PUT'])]
    public function editName(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $vault = $this->vaultService->editNameVault($data['name'], $id);

        return $this->json([
            'message' => 'Vault name updated successfully',
            'vault' => $vault,
        ]);
    }

    #[Route('/vault/edit/code/{id}', name: 'vault.editCode', methods: ['PUT'])]
    public function editCode(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $vault = $this->vaultService->editCodeVault($id, $data['user']);

        return $this->json([
            'message' => 'Vault code updated successfully',
            'vault' => $vault,
        ]);
    }
}
