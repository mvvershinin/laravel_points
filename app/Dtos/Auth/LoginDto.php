<?php

namespace App\Dtos\Auth;

class LoginDto
{
    public function __construct(
        public string $email,
        public string $password
    ) {}
}
