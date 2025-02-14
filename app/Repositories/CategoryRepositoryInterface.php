<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface CategoryRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator;

    public function register(array $data): ?Category;

    public function update(Category $category, array $data): int;

    public function delete(Category $category): bool;

    public function find(int $id): ?Category;
}
