<?php

namespace App\Controller;

use App\Repository\CoffreRepository;
use App\Repository\UserRepository;
use App\Service\CodeGeneratorService;
use App\Service\CoffreService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
final class CoffreController extends AbstractController
{
    #[Route('/coffres', name: 'coffre-all')]
    public function index(CoffreService $coffreService, CoffreRepository $coffreRepository): JsonResponse
    {
        $coffres = $coffreService->findAll($coffreRepository);
        //TODO: Use a Serializer instead
        $coffres = array_map(fn($coffre) => [
                'id' => $coffre->getId(),
                'name' => $coffre->getName(),
            ], $coffres);
        return $this->json($coffres);
    }

    #[Route('/coffre/add', name: 'coffre-add', methods: ['POST'])]
    public function create(Request $request, CoffreService $coffreService, CodeGeneratorService $codeGeneratorService, CoffreRepository $cr, UserRepository $ur, EntityManagerInterface $em): JsonResponse
    {
        $payload = json_decode($request->getContent(), true);
        $code = $coffreService->add($payload['name'], $payload['user'],$codeGeneratorService, $cr, $ur, $em);
        return $this->json([
            'code' => $code
        ]);
    }

    #[Route('/coffre/update/{id}', name: 'cofre-update', methods: ['PUT'])]
    public function edit(Request $request, string $id, CoffreService $coffreService, CoffreRepository$coffreRepository, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $isUpdated = $coffreService->update($id, $data['name'], $coffreRepository, $em);
        return $this->json([
            'message' => $isUpdated ? 'Coffre edited successfully' : 'Coffre not found',
        ]);
    }
}
