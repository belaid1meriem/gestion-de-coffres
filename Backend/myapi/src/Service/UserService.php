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

/**
 * Service responsible for user authentication and account management.
 */
class UserService
{
    /**
     * @param EntityManagerInterface $entityManager ORM entity manager for persisting user data.
     * @param UserPasswordHasherInterface $passwordHasher Handles password hashing and validation.
     * @param ValidatorInterface $validator Symfony validator for input validation (currently unused here).
     * @param SerializerInterface $serializer Symfony serializer (currently unused here).
     * @param JWTTokenManagerInterface $jwtManager Service for generating JWT tokens.
     * @param UserRepository $userRepository Repository for accessing user data.
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
        private ValidatorInterface $validator,
        private SerializerInterface $serializer,
        private JWTTokenManagerInterface $jwtManager,
        private UserRepository $userRepository
    ) {}

    /**
     * Registers a new user and returns a JWT token along with user info.
     *
     * @param string $email User email (must be unique).
     * @param string $password Plain text password.
     * @param string $firstName User's first name.
     * @param string $lastName User's last name.
     *
     * @return AuthResponse Response containing user info and JWT token.
     *
     * @throws ConflictHttpException If the email is already registered.
     */
    public function signup(string $email, string $password, string $firstName, string $lastName): AuthResponse
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

        return new AuthResponse($user, $token);
    }

    /**
     * Authenticates a user and returns a JWT token with user info.
     *
     * @param string $email User email.
     * @param string $password Plain text password.
     *
     * @return AuthResponse Response containing user info and JWT token.
     *
     * @throws UnauthorizedHttpException If credentials are invalid.
     */
    public function login(string $email, string $password): AuthResponse
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user || !$this->passwordHasher->isPasswordValid($user, $password)) {
            throw new UnauthorizedHttpException('Bearer', 'Invalid credentials.');
        }

        $token = $this->jwtManager->create($user);

        return new AuthResponse($user, $token);
    }
}
