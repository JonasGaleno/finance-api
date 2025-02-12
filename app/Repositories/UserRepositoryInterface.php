<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator;

    public function update(User $user, array $data): int;

    public function delete(User $user): bool;

    public function find(int $id): ?User;
}
