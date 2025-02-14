<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository
    ) {
    }

    public function all(Request $request): LengthAwarePaginator
    {
        $categories = $this->categoryRepository->all($request);

        if ($categories->isEmpty()) {
            throw new \Exception('Categories not found', 204);
        }

        return $categories;
    }

    public function register(array $data): Category
    {
        return DB::transaction(function () use ($data) {
            return $this->categoryRepository->register($data);
        });
    }

    public function update(array $data, int $id): Category
    {
        return DB::transaction(function () use ($data, $id) {
            $category = $this->categoryRepository->find($id);

            if (!$category) {
                throw new \Exception('Category not found', 400);
            }

            $this->categoryRepository->update($category, $data);

            return $this->categoryRepository->find($id);
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $category = $this->categoryRepository->find($id);

            if (!$category) {
                throw new \Exception('Category not found', 400);
            }

            $categoryRemoved = $this->categoryRepository->delete($category);

            if (!$categoryRemoved) {
                throw new \Exception('An error occurred while removing the category');
            }

            return $categoryRemoved;
        });
    }

    public function find(int $id): Category
    {
        $category = $this->categoryRepository->find($id);

        if (!$category) {
            throw new \Exception('Category not found', 400);
        }

        return $category;
    }
}
