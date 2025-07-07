<?php

namespace App\Service;

use App\Entity\Historique;
use App\Repository\CodeRepository;
use Proxies\__CG__\App\Entity\Coffre;

class CodeSearchService
{
   public function search(string $code, CodeRepository $codeRepository): ?Coffre
   {
        $codeObject = $codeRepository->findByCode($code);

        if (!$codeObject) return null;

        return $codeObject->getHistorique()->getCoffre();
        
   }
}