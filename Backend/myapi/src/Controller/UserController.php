<?php

namespace App\Controller;

use App\DTO\LoginRequest;
use App\DTO\SignupRequest;
use App\Service\UserService;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;


#[Route(path: '/api')]

class UserController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
        private ValidatorInterface $validator,
        private SerializerInterface $serializer,
        private JWTTokenManagerInterface $jwtManager,
        private UserRepository $userRepository,
        private UserService $userService
    ) {}

    #[Route('/signup', name: 'api_signup', methods: ['POST'])]
    public function signup(SignupRequest $request): JsonResponse
    {
        try {
            $signupResponse = $this->userService->signup(
                $request->email,
                $request->password,
                $request->firstName,
                $request->lastName
            );
            return new JsonResponse([
                'message' => 'User created successfully',
                'user' => [
                    'id' => $signupResponse->user->getId(),
                    'email' => $signupResponse->user->getEmail(),
                    'firstName' => $signupResponse->user->getFirstName(),
                    'lastName' => $signupResponse->user->getLastName(),
                ],
                'token' => $signupResponse->token
            ], Response::HTTP_CREATED);

        } catch (ConflictHttpException $e) {
            return new JsonResponse(['error' => $e->getMessage()],  Response::HTTP_CONFLICT);
        }
    }

    #[Route('/login', name: 'api_login', methods: ['POST'])]
    public function login(LoginRequest $request): JsonResponse
    {
        try {
           $loginResponse = $this->userService->login(
                $request->email,
                $request->password
            );

            
            return new JsonResponse([
                'message' => 'Login successful',
                'user' => [
                    'id' => $loginResponse->user->getId(),
                    'email' => $loginResponse->user->getEmail(),
                    'firstName' => $loginResponse->user->getFirstName(),
                    'lastName' => $loginResponse->user->getLastName(),
                ],
                'token' => $loginResponse->token
            ]);

        } catch (UnauthorizedHttpException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_UNAUTHORIZED);
        }
    }

    #[Route('/profile', name: 'api_profile', methods: ['GET'])]
    public function profile(): JsonResponse
    {
        $user = $this->getUser();
        
        return new JsonResponse([
            'user' => [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
            ]
        ]);
    }
}