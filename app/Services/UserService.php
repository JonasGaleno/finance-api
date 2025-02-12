<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {
    }

    public function all(Request $request): LengthAwarePaginator
    {
        $users = $this->userRepository->all($request);

        if ($users->isEmpty()) {
            throw new \Exception('Users not found');
        }

        return $users;
    }

    public function update(array $data, int $id): User
    {
        return DB::transaction(function () use ($data, $id) {
            $user = $this->userRepository->find($id);

            if (!$user) {
                throw new \Exception('User not found');
            }

            $this->userRepository->update($user, $data);

            return $this->userRepository->find($id);
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $user = $this->userRepository->find($id);

            if (!$user) {
                throw new \Exception('User not found');
            }

            $userRemoved = $this->userRepository->delete($user);

            if (!$userRemoved) {
                throw new \Exception('An error occurred while removing the user');
            }

            return $userRemoved;
        });
    }

    public function find(int $id): User
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            throw new \Exception('User not found');
        }

        return $user;
    }
}
