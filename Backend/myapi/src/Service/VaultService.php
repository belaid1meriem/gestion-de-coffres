<?php
namespace App\Service;

use App\Entity\History;
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

    public function createVault(string $name, int $user): Vault
    {
        $vault = new Vault()
            ->setName($name)
            ->setCode($this->generateCode());

        $this->entityManager->persist($vault);
        $this->entityManager->flush();

        $this->historyService->createHistory($vault->getCode(), $vault->getId(), $user);
    
        return $vault;
    }


    public function editNameVault(string $name, int $id): Vault
    {
        $vault = $this->vaultRepository->find($id);

        if (!$vault) {
            throw new \Exception('Vault not found');
        }

        $vault->setName($name);
        $this->entityManager->flush();

        return $vault;
    }

    public function editCodeVault(int $id, int $user): Vault
    {
        $vault = $this->vaultRepository->find($id);

        if (!$vault) {
            throw new \Exception('Vault not found');
        }
        
        $code = $this->generateCode(); 

        $vault->setCode($code);
        $this->entityManager->flush();

        $this->historyService->createHistory($vault->getCode(), $vault->getId(), $user);

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
}