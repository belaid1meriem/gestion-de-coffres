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

        $em->persist($coffre);
        $code = $codeGeneratorService->generateCodeWithCoffre($coffre, $user, $cr, $ur, $em);
        return [$code, $coffre];
    }
}