<?php
namespace App\Service;

use App\Entity\History;
use App\Entity\Vault;
use App\Repository\HistoryRepository;
use App\Repository\VaultRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;


class HistoryService
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly VaultRepository $vaultRepository,
        private readonly UserRepository $userRepository,
        private readonly HistoryRepository $historyRepository,
    )
    {}

    public function getHistoryByVault(int $id): array
    {
        return $this->historyRepository->findBy(['vault'=>$id]);
    }

    public function createHistory(string $code, int $vault, int $user): History
    {
        $vault = $this->vaultRepository->find($vault);
        if (!$vault){
            throw new \Exception('Vault Not Found');
        }

        $user = $this->userRepository->find($user);
        if(!$user){
            throw new \Exception('User Not Found');
        }

        $isCodeUnique = $this->historyRepository->findOneBy(['code' => $code]);
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