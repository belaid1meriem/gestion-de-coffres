<?php

namespace App\Controller;

use App\DTO\CreateEditVaultRequest;
use App\Entity\Vault;
use App\Service\VaultService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/api')]
/**
 * Controller responsible for managing operations related to vaults.
 */
final class VaultController extends AbstractController
{
    /**
     * @param VaultService $vaultService Handles business logic related to vaults.
     */
    public function __construct(
        private VaultService $vaultService,
    ) {}

    /**
     * Retrieves all vaults belonging to the authenticated user.
     *
     * @return JsonResponse JSON response containing the list of vaults.
     */
    #[Route('/vaults', name: 'vault.all', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $vaults = $this->vaultService->getVaults();

        return $this->json($vaults, Response::HTTP_OK);
    }

    /**
     * Creates a new vault for the authenticated user.
     *
     * @param CreateEditVaultRequest $request The request DTO containing vault name.
     *
     * @return JsonResponse JSON response with the created vault data.
     */
    #[Route('/vault/create', name: 'vault.create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload]
        CreateEditVaultRequest $request
    ): JsonResponse {
        $vault = $this->vaultService->createVault($this->getUser(), $request->name);

        return $this->json([
            'message' => 'Vault created successfully',
            'vault' => $vault,
        ], Response::HTTP_CREATED);
    }

    /**
     * Updates the name of a specific vault.
     *
     * @param CreateEditVaultRequest $request The request DTO containing the new name.
     * @param Vault $vault The vault entity to be updated.
     *
     * @return JsonResponse JSON response with the updated vault.
     */
    #[Route('/vault/edit/name/{vault}', name: 'vault.editName', methods: ['PUT'])]
    public function editName(
        #[MapRequestPayload]
        CreateEditVaultRequest $request,
        Vault $vault
    ): JsonResponse {
        $vault = $this->vaultService->editNameVault($vault, $request->name);

        return $this->json([
            'message' => 'Vault name updated successfully',
            'vault' => $vault,
        ], Response::HTTP_OK);
    }

    /**
     * Updates the access code of a specific vault.
     *
     * @param Vault $vault The vault entity whose code is to be regenerated.
     *
     * @return JsonResponse JSON response with the updated vault code.
     */
    #[Route('/vault/edit/code/{vault}', name: 'vault.editCode', methods: ['PUT'])]
    public function editCode(Vault $vault): JsonResponse
    {
        $vault = $this->vaultService->editCodeVault($vault, $this->getUser());

        return $this->json([
            'message' => 'Vault code updated successfully',
            'vault' => $vault,
        ], Response::HTTP_OK);
    }

    /**
     * Searches for a vault by its access code.
     *
     * @param string $code The vault's code.
     *
     * @return JsonResponse JSON response containing the vault if found.
     */
    #[Route('/vault/search/{code}', name: 'vault.search', methods: ['GET'])]
    public function search(string $code): JsonResponse
    {
        $vault = $this->vaultService->searchByCode($code);

        return $this->json([
            'vault' => $vault,
        ], Response::HTTP_OK);
    }
}
