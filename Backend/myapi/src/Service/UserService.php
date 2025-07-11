<?php
namespace App\Service;

use App\Repository\UserRepository;


class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository
    ){}

    public function login(string $email, string $password)
    {
        $user = $this->userRepository->findOneBy(["email"=> $email]);

    }
}