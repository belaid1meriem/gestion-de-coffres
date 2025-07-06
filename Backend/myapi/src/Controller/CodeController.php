<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class CodeController extends AbstractController
{
    #[Route('/code/{code}', name: 'app_code')]
    public function index(int $code): JsonResponse
    {
        return $this->json([
            'code' => $code,
            'coffre' => [
                'id' => 1,
                'name' => 'coffre 123',
                'code' => $code
            ],
        ]);
    }
}
