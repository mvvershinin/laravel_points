<?php

namespace App\Dtos\Auth;

class RegisterDto
{
    public function __construct(
        public string $email,
        public string $password
    ) {}
}
