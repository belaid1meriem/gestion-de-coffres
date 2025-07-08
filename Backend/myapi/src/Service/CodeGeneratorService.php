<?php
namespace App\Service;

use App\Entity\Code;
use App\Entity\Coffre;
use App\Entity\Historique;
use App\Entity\User;
use App\Repository\CoffreRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class CodeGeneratorService
{
    public function generateCode(int $coffreId, User $user, CoffreRepository $cr, UserRepository $ur, EntityManagerInterface $em): ?string
    {
        $coffre = $cr->findCoffreById($coffreId);

        if (!$coffre) return null;

        $user = $ur->findUserById($user);
        if (!$user) return null;

        $code = $this->generateCode($coffre, $user, $em);
        $coffre->setCode($code);

        $historique = new Historique()
            ->setCoffre($coffre)
            ->setUser(user: $user)
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setCode($code);

        $em->persist($historique);
        $em->flush();

        return $historique->getCode()->getCode();
    }

    public function generateCodeWithCoffre(Coffre $coffre, string $user, CoffreRepository $cr, UserRepository $ur, EntityManagerInterface $em): ?string
    {
        $user = $ur->findUserById($user);
        if (!$user) return null;

        $code = new Code()
            ->setCode(bin2hex(random_bytes(18)));

        $historique = new Historique()
            ->setCoffre($coffre)
            ->setUser(user: $user)
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setCode($code);

        $em->persist($historique);
        $em->flush();

        return $historique->getCode()->getCode();
    }
}
