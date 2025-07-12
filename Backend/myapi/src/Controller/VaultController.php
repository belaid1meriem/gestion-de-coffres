<?php

namespace App\Controller;

use App\DTO\CreateEditVaultRequest;
use App\Entity\Vault;
use App\Service\VaultService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Validator\Validator\ValidatorInterface;


#[Route(path: '/api')]
final class VaultController extends AbstractController
{
    public function __construct(
    private VaultService $vaultService,
    private ValidatorInterface $validator 
    ) {}

    #[Route('/vaults', name: 'vault.all', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $vaults = $this->vaultService->getVaults();

        return $this->json($vaults);
    }

    #[Route('/vault/create', name: 'vault.create', methods: ['POST'])]
    public function create(CreateEditVaultRequest $request): JsonResponse
    {

        $vault = $this->vaultService->createVault($this->getUser(),$request->name);

        return $this->json([
            'message' => 'Vault created successfully',
            'vault' => $vault,
        ], 201);
    }

    #[Route('/vault/edit/name/{vault}', name: 'vault.editName', methods: ['PUT'])]
    public function editName(CreateEditVaultRequest $request,Vault $vault): JsonResponse
    {
        $vault = $this->vaultService->editNameVault($vault,$request->name);

        return $this->json([
            'message' => 'Vault name updated successfully',
            'vault' => $vault,
        ]);
    }

    #[Route('/vault/edit/code/{vault}', name: 'vault.editCode', methods: ['PUT'])]
    public function editCode(Vault $vault): JsonResponse
    {
        $vault = $this->vaultService->editCodeVault($vault, $this->getUser());

        return $this->json([
            'message' => 'Vault code updated successfully',
            'vault' => $vault,
        ]);
    }

    #[Route('/vault/search/{code}', name: 'vault.search', methods: ['GET'])]
    public function search(string $code): JsonResponse
    {
        $vault = $this->vaultService->searchByCode($code);

        return $this->json([
            'vault' => $vault,
        ]);
    }
}
