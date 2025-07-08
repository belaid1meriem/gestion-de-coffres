<?php

namespace App\Service;

use App\Repository\HistoriqueRepository;


class HistoriqueService
{
    public function findAll(HistoriqueRepository $hr): array
    {
        return $hr->findAll(); ; 
    }
}    