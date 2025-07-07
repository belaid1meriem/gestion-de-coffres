<?php

namespace App\Controller;

use App\Repository\CodeRepository;
use App\Service\CodeGeneratorService;
use App\Service\CodeSearchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CoffreRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

final class CodeController extends AbstractController
{
    #[Route('/code/recherche/{code}', name: 'code-search')]
    public function index(string $code, CodeSearchService $codeSearchService, CodeRepository $codeRepository): JsonResponse
    {
        $coffre = $codeSearchService->search($code, $codeRepository);
        return $this->json([
            'code' => $code,
            'coffre' => $coffre ? [
                'id' => $coffre->getId(),
                'name' => $coffre->getName(),
            ] : null,
        ]);
    }

    #[Route('/code/new', name: 'new-code', methods: ['POST'])]
    public function generate(Request $request, CodeGeneratorService $gen, CoffreRepository $cr, UserRepository $ur, EntityManagerInterface $em): JsonResponse
    {
        $payload = json_decode($request->getContent(), true);
        $code = $gen->generateCode($payload, $cr, $ur, $em); 
        return $this->json([
            'code' => $code,
        ]);
    }
}
