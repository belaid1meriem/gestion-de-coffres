<?php
namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Coffre;
use App\Entity\Code;
use App\Entity\Historique;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Créer 2 utilisateurs
        $user1 = new User();
        $user1->setUsername('alice')->setEmail('alice@mail.com')->setPasswordHash('password1');
        $manager->persist($user1);

        $user2 = new User();
        $user2->setUsername('bob')->setEmail('bob@mail.com')->setPasswordHash('password2');
        $manager->persist($user2);

        // Créer 2 coffres
        $coffre1 = new Coffre();
        $coffre1->setName('Coffre A');
        $manager->persist($coffre1);

        $coffre2 = new Coffre();
        $coffre2->setName('Coffre B');
        $manager->persist($coffre2);

        // Créer 2 codes
        $code1 = new Code();
        $code1->setCode('SECRET-123');
        $manager->persist($code1);

        $code2 = new Code();
        $code2->setCode('SECRET-456');
        $manager->persist($code2);

        // Créer un historique pour chaque code
        $historique1 = new Historique();
        $historique1->setCode($code1);
        $historique1->setCoffre($coffre1);
        $historique1->setUser($user1);
        $historique1->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($historique1);

        $code1->setHistorique($historique1); // liaison OneToOne

        $historique2 = new Historique();
        $historique2->setCode($code2);
        $historique2->setCoffre($coffre2);
        $historique2->setUser($user2);
        $historique2->setUpdatedAt(new \DateTimeImmutable('-1 day'));
        $manager->persist($historique2);

        $code2->setHistorique($historique2); // liaison OneToOne

        // Enregistrement
        $manager->flush();
    }
}
