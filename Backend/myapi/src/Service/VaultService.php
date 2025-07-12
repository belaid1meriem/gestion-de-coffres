<?php
namespace App\Service;

use App\Entity\User;
use App\Entity\Vault;
use App\Repository\HistoryRepository;
use App\Repository\VaultRepository;
use App\Repository\UserRepository;
use App\Service\HistoryService;
use Doctrine\ORM\EntityManagerInterface;

class VaultService
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly VaultRepository $vaultRepository,
        private readonly UserRepository $userRepository,
        private readonly HistoryService $historyService,
        private readonly HistoryRepository $historyRepository,
    )
    {}

    public function getVaults(): array
    {
        return $this->vaultRepository->findAll();
    }

    public function createVault(User $user,string $name): Vault
    {
        $vault = new Vault()
            ->setName($name)
            ->setCode($this->generateCode());

        $this->entityManager->persist($vault);
        $this->entityManager->flush();

        $this->historyService->createHistory($vault->getCode(), $vault, $user);
    
        return $vault;
    }


    public function editNameVault(Vault $vault,string $name): Vault
    {
        $vault->setName($name);
        $this->entityManager->flush();

        return $vault;
    }

    public function editCodeVault(Vault $vault, User $user): Vault
    {
        $code = $this->generateCode(); 

        $vault->setCode($code);
        $this->entityManager->flush();

        $this->historyService->createHistory($vault->getCode(), $vault, $user);

        return $vault;
    }

    private function generateCode(): string
    {
        $code = bin2hex(random_bytes(18));

        // Ensure the code is unique
        while ($this->historyRepository->findOneBy(['code' => $code])) {
            $code = bin2hex(random_bytes(18));
        }
        
        return $code;
    }

    public function searchByCode(string $code): ?Vault
    {
        return $this->historyRepository
            ->findOneBy(['code' => $code])
            ->getVault();
    }
}