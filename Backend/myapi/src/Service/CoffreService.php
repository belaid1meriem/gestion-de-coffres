<?php

namespace App\Service;

use App\Entity\Coffre;
use App\Repository\CoffreRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class CoffreService
{
    public function findAll(CoffreRepository $cr): array
    {
        return $cr->findAll(); ;
    }

    public function add(string $name, string $user, CodeGeneratorService $codeGeneratorService, CoffreRepository $cr, UserRepository $ur, EntityManagerInterface $em): array
    {
        $coffre = new Coffre()
            ->setName($name);

        $code = $codeGeneratorService->generateCodeWithCoffre($coffre, $user, $cr, $ur, $em);
        $coffre->setCode($code);
        $em->persist($coffre);

        // Return an object typed Coffre

        return [$code, $coffre];
    }


    public function update(string $id, string $name, CoffreRepository $cr, EntityManagerInterface $em): bool
    {
        $coffre = $cr->find($id);
        $updatedOk = false;
        if ($coffre) {
            $updatedOk = true;
        }
        $coffre->setName($name);
        $em->flush();

        return $updatedOk;
    }
}
