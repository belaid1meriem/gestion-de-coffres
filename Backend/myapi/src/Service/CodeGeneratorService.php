<?php
namespace App\Service;

use App\Entity\Code;
use App\Entity\Historique;
use App\Repository\CoffreRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class CodeGeneratorService
{
    public function generateCode($payload, CoffreRepository $cr, UserRepository $ur, EntityManagerInterface $em): ?string
    {
        $coffre = $cr->findCoffreById($payload['coffre']);
        if (!$coffre) return null;

        $user = $ur->findUserById($payload['user']);
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