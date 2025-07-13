<?php

namespace App\Service;

use App\Entity\History;
use App\Entity\User;
use App\Entity\Vault;
use App\Repository\HistoryRepository;
use App\Repository\VaultRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Service class responsible for managing history records related to vault access.
 */
class HistoryService
{
    /**
     * @param EntityManagerInterface $entityManager Handles persistence of entities.
     * @param VaultRepository $vaultRepository Repository for Vault entities.
     * @param UserRepository $userRepository Repository for User entities.
     * @param HistoryRepository $historyRepository Repository for History entities.
     */
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly VaultRepository $vaultRepository,
        private readonly UserRepository $userRepository,
        private readonly HistoryRepository $historyRepository,
    ) {}

    /**
     * Retrieves all history records associated with a specific vault.
     *
     * @param Vault $vault The vault entity for which history is being retrieved.
     *
     * @return History[] List of history records.
     */
    public function getHistoryByVault(Vault $vault): array
    {
        return $this->historyRepository->findBy(['vault' => $vault]);
    }

    /**
     * Creates a new history record for a vault access using a unique code.
     *
     * @param string $code A unique code associated with the history entry.
     * @param Vault $vault The vault being accessed.
     * @param User $user The user who accessed the vault.
     *
     * @return History The created history record.
     *
     * @throws \Exception If the code is not unique.
     */
    public function createHistory(string $code, Vault $vault, User $user): History
    {
        $isCodeUnique = !$this->historyRepository->findOneBy(['code' => $code]);
        if (!$isCodeUnique) {
            throw new \Exception('Code Already Exists');
        }

        $history = new History();
        $history
            ->setUser($user)
            ->setVault($vault)
            ->setCode($code)
            ->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($history);
        $this->entityManager->flush();

        return $history;
    }
}
