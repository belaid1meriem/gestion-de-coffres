<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
final class CoffreController extends AbstractController
{
    #[Route('/coffres', name: 'coffre')]
    public function index(): JsonResponse
    {
        return $this->json([
            'coffres' => [
                ['id' => 1, 'name' => 'Coffre A'],
                ['id' => 2, 'name' => 'Coffre B'],
             ]
        ]);
    }

    #[Route('/coffre', name: 'create_coffre', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        return $this->json([
            'coffre' => [
                'id' => $data['id'],
                'name' => $data['name'],
                'code'=> $data['code'],
            ],
            'message' => 'Coffre created successfully',
        ]);
    }

    #[Route('/coffre', name: 'edit_coffre', methods: ['PUT'])]
    public function edit(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        return $this->json([
            'coffre' => [
                'id' => $data['id'],
                'name' => $data['name'],
                'code'=> $data['code'],
            ],
            'message' => 'Coffre edited successfully',
        ]);
    }
}
