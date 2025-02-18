<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;


class CategoryRepository implements CategoryRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator
    {
        // Filtros
        $query = Category::query();

        if ($request->has('name') && !empty($request->name)) {
            $query->where('name', $request->name);
        }

        if ($request->has('user_id') && !empty($request->user_id)) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);
        }

        // Ordenação
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');

        $query->orderBy($sortBy, $sortDirection);

        // Paginação
        $perPage = $request->input('per_page', 10);
        $categories = $query->paginate($perPage);

        return $categories;
    }

    public function register(array $data): ?Category
    {
        return Category::create($data);
    }

    public function update(Category $category, array $data): int
    {
        return $category->update($data);
    }

    public function delete(Category $category): bool
    {
        return $category->delete();
    }

    public function find(int $id): ?Category
    {
        return Category::find($id);
    }
}
