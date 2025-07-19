<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Vault;
use App\Repository\HistoryRepository;
use App\Repository\VaultRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

/**
 * Service responsible for managing vault operations such as creation, update, code regeneration, and lookup by code.
 */
class VaultService
{
    /**
     * @param EntityManagerInterface $entityManager Manages persistence and flushing of entities.
     * @param VaultRepository $vaultRepository Repository to handle Vault entity operations.
     * @param UserRepository $userRepository Repository to handle User entity operations.
     * @param HistoryService $historyService Service for creating vault access history.
     * @param HistoryRepository $historyRepository Repository for searching history entries (used to ensure unique codes).
     */
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly VaultRepository $vaultRepository,
        private readonly UserRepository $userRepository,
        private readonly HistoryService $historyService,
        private readonly HistoryRepository $historyRepository,
    ) {}

    /**
     * Returns a list of all vaults.
     *
     * @return Vault[] Array of vault entities.
     */
    public function getVaults(): array
    {
        return $this->vaultRepository->findAll();
    }

    /**
     * Creates a new vault associated with the given user and generates its initial access code.
     * Also creates a history entry for the creation.
     *
     * @param User $user The user who is creating the vault.
     * @param string $name The name of the vault.
     *
     * @return Vault The newly created vault.
     */
    public function createVault(User $user, string $name): Vault
    {
        $vault = new Vault();
        $vault
            ->setName($name)
            ->setCode($this->generateCode());

        $this->entityManager->persist($vault);
        $this->entityManager->flush();

        $this->historyService->createHistory($vault->getCode(), $vault, $user);

        return $vault;
    }

    /**
     * Updates the name of a vault.
     *
     * @param Vault $vault The vault to be renamed.
     * @param string $name The new name to assign.
     *
     * @return Vault The updated vault.
     */
    public function editNameVault(Vault $vault, string $name): Vault
    {
        $vault->setName($name);
        $this->entityManager->flush();

        return $vault;
    }

    /**
     * Regenerates the access code of a vault and stores a history record.
     *
     * @param Vault $vault The vault whose code is to be updated.
     * @param User $user The user triggering the code change.
     *
     * @return Vault The updated vault with a new code.
     */
    public function editCodeVault(Vault $vault, User $user): Vault
    {
        $code = $this->generateCode();
        $vault->setCode($code);
        $this->entityManager->flush();

        $this->historyService->createHistory($code, $vault, $user);

        return $vault;
    }

    /**
     * Generates a secure, random, and unique access code for a vault.
     *
     * @return string A unique 36-character hexadecimal code.
     */
    private function generateCode(): string
    {
        $code = bin2hex(random_bytes(18));

        // Ensure the code is unique in the history table
        $maxLoop = 10;
        while ($this->historyRepository->findOneBy(['code' => $code]) && $maxLoop > 0) {
            $code = bin2hex(random_bytes(18));
            $maxLoop--;
        }
        if ($maxLoop === 0) {
            throw new Exception('Failed to generate code');
        }

        return $code;
    }

    /**
     * Finds a vault using an access code found in the history records.
     *
     * @param string $code The code used to identify the vault.
     *
     * @return Vault|null The corresponding vault if found, or null.
     */
    public function searchByCode(string $code): ?Vault
    {
        $history = $this->historyRepository->findOneBy(['code' => $code]);

        return $history ? $history->getVault() : null;
    }
}
