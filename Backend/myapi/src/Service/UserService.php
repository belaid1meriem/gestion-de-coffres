<?php
namespace App\Service;

use App\DTO\AuthResponse;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;


class UserService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
        private ValidatorInterface $validator,
        private SerializerInterface $serializer,
        private JWTTokenManagerInterface $jwtManager,
        private UserRepository $userRepository
    ){}

    public function signup(string $email, string $password, string $firstName, string $lastName) : AuthResponse
    {
        // Check if user already exists
        if ($this->userRepository->findOneBy(['email' => $email])) {
            throw new ConflictHttpException('Email is already registered.');
        }

        $user = new User();
        $user->setEmail($email);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $token = $this->jwtManager->create($user);


        return new AuthResponse(
            $user,
            $token
        );
    }

    public function login(string $email, string $password): AuthResponse
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);
            
        if (!$user || !$this->passwordHasher->isPasswordValid($user, $password)) {
            throw new UnauthorizedHttpException('Invalid credentials.');
        }

        $token = $this->jwtManager->create($user);

        return new AuthResponse(
            $user,
            $token
        );
    }
}