<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class UserController extends AbstractController
{
    #[Route('/login', name: 'user.login', methods:['POST'])]
    public function login(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        return $this->json([
            'email' => $data['email'],
            'password' => $data['password'],
            'message' => 'Login successful',
        ]);
    }

    #[Route('/signup', name: 'user.signup', methods:['POST'])]
    public function signup(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        return $this->json([
            'email' => $data['email'],
            'password' => $data['password'],
            'message' => 'signup successful',
        ]);
    }
}
