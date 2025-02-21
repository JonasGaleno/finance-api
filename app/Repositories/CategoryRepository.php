<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class CategoryRepository implements CategoryRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator
    {
        $filters = $request->query();
        $cacheKey = 'categories_' . md5(json_encode($filters));
        $cacheTime = 10;
        
        return Cache::remember($cacheKey, now()->addMinutes($cacheTime), function () use ($request) {
            $query = Category::with(['user:id,name,email']);
        
            // Filtros
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
            
            return $query->paginate($perPage);
        });
    }

    public function register(array $data): ?Category
    {
        return Category::create($data)->load(['user:id,name,email']);;
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
        $cacheKey = "category_{$id}";
        $cacheTime = 10;

        return Cache::remember($cacheKey, now()->addMinutes($cacheTime), function () use ($id) {
            return Category::with(['user:id,name,email'])->find($id);
        });
    }
}
