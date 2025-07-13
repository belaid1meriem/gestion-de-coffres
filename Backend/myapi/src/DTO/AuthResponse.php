<?php

namespace App\DTO;

use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class AuthResponse
{
    #[Assert\NotBlank]
    public User $user;
    
    #[Assert\NotBlank]
    public string $token;

    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
    }
}