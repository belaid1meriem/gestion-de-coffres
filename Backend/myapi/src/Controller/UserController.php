<?php

namespace App\Controller;

use App\DTO\SignupRequest;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route(path: '/api')]

class UserController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
        private ValidatorInterface $validator,
        private SerializerInterface $serializer,
        private JWTTokenManagerInterface $jwtManager,
        private UserRepository $userRepository
    ) {}

    #[Route('/signup', name: 'api_signup', methods: ['POST'])]
    public function signup(Request $request): JsonResponse
    {
        try {
            $signupRequest = $this->serializer->deserialize(
                $request->getContent(),
                SignupRequest::class,
                'json'
            );

            $errors = $this->validator->validate($signupRequest);
            if (count($errors) > 0) {
                $errorMessages = [];
                foreach ($errors as $error) {
                    $errorMessages[] = $error->getMessage();
                }
                return new JsonResponse(['errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
            }

            // Check if user already exists
            if ($this->userRepository->findOneBy(['email' => $signupRequest->email])) {
                return new JsonResponse(['error' => 'User already exists'], Response::HTTP_CONFLICT);
            }

            $user = new User();
            $user->setEmail($signupRequest->email);
            $user->setFirstName($signupRequest->firstName);
            $user->setLastName($signupRequest->lastName);
            $user->setPassword($this->passwordHasher->hashPassword($user, $signupRequest->password));

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $token = $this->jwtManager->create($user);

            return new JsonResponse([
                'message' => 'User created successfully',
                'user' => [
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'firstName' => $user->getFirstName(),
                    'lastName' => $user->getLastName(),
                ],
                'token' => $token
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Invalid JSON'], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/login', name: 'api_login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            
            if (!isset($data['email']) || !isset($data['password'])) {
                return new JsonResponse(['error' => 'Email and password are required'], Response::HTTP_BAD_REQUEST);
            }

            $user = $this->userRepository->findOneBy(['email' => $data['email']]);
            
            if (!$user || !$this->passwordHasher->isPasswordValid($user, $data['password'])) {
                return new JsonResponse(['error' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
            }

            $token = $this->jwtManager->create($user);

            return new JsonResponse([
                'message' => 'Login successful',
                'user' => [
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'firstName' => $user->getFirstName(),
                    'lastName' => $user->getLastName(),
                ],
                'token' => $token
            ]);

        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Invalid JSON'], Response::HTTP_BAD_REQUEST);
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