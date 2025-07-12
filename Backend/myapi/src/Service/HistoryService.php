<?php
namespace App\Service;

use App\Entity\History;
use App\Entity\User;
use App\Entity\Vault;
use App\Repository\HistoryRepository;
use App\Repository\VaultRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;



class HistoryService
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly VaultRepository $vaultRepository,
        private readonly UserRepository $userRepository,
        private readonly HistoryRepository $historyRepository,
    )
    {}

    public function getHistoryByVault(Vault $vault): array
    {
        return $this->historyRepository->findBy(['vault'=>$vault]);
    }

    public function createHistory(string $code, Vault $vault, User $user): History
    {
        $isCodeUnique =!$this->historyRepository->findOneBy(['code' => $code]);
        if(!$isCodeUnique){
            throw new \Exception('Code Already Exists');
        }

        $history = new History()
            ->setUser($user)
            ->setVault($vault)
            ->setCode($code)
            ->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($history);
        $this->entityManager->flush();

        return $history;
    }

}