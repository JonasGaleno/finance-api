<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\JsonResponse;

interface AuthRepositoryInterface
{
    public function register(array $data): User;
}
