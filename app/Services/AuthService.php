<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\AuthRepositoryInterface;
use Illuminate\Http\Request;

class AuthService
{
    public function __construct(
        protected AuthRepositoryInterface $authRepository
    ) {
    }

    public function register(array $data): User
    {
        return $this->authRepository->register($data);
    }
}
