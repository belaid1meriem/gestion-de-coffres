<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CreateEditVaultRequest
{
    #[Assert\NotBlank]
    public string $name;
}