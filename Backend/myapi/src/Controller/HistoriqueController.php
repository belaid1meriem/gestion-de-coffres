<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class HistoriqueController extends AbstractController
{
    #[Route('/historique', name: 'app_historique')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to historique',
        ]);
    }
}
