<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Vault;
use App\Entity\History;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Create Users
        $users = [];
        for ($i = 1; $i <= 3; $i++) {
            $user = new User();
            $user->setEmail("user$i@example.com");
            $user->setPasswordHash(hash('sha256', "password$i")); // Just a dummy hash
            $manager->persist($user);
            $users[] = $user;
        }

        // Create Vaults
        $vaults = [];
        for ($i = 1; $i <= 5; $i++) {
            $vault = new Vault();
            $vault->setName("Vault $i");
            $vault->setCode(bin2hex(random_bytes(18))); // 36 hex characters
            $manager->persist($vault);
            $vaults[] = $vault;
        }

        // Create Histories
        foreach ($vaults as $vault) {
            $historyCount = rand(1, 3);
            for ($j = 0; $j < $historyCount; $j++) {
                $history = new History();
                $history->setVault($vault);
                $history->setUser($users[array_rand($users)]);
                $history->setCode(bin2hex(random_bytes(18)));
                $history->setUpdatedAt(new \DateTimeImmutable(sprintf('-%d days', rand(1, 30))));
                $manager->persist($history);
            }
        }

        $manager->flush();
    }
}
