<?php

namespace App\Repositories;

use App\Models\Budget;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class BudgetRepository implements BudgetRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator
    {
        $filters = $request->query();
        $cacheKey = 'budgets_' . md5(json_encode($filters));
        $cacheTime = 10;
        
        return Cache::remember($cacheKey, now()->addMinutes($cacheTime), function () use ($request) {
            $query = Budget::with([
                'user:id,name,email',
                'category:id,name,type'
            ]);
    
            // Filtros
            if ($request->has('category_id') && !empty($request->category_id)) {
                $query->where('category_id', $request->category_id);
            }
    
            if ($request->has('user_id') && !empty($request->user_id)) {
                $query->where('user_id', $request->user_id);
            }
    
            if ($request->has('limit_amount') && !empty($request->limit_amount)) {
                $query->where('limit_amount', $request->limit_amount);
            }
    
            if ($request->has('month') && !empty($request->month)) {
                $query->where('month', $request->month);
            }
    
            if ($request->has('year') && !empty($request->year)) {
                $query->where('year', $request->year);
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

    public function register(array $data): ?Budget
    {
        return Budget::create($data)->load([
            'user:id,name,email',
            'category:id,name,type'
        ]);
    }

    public function update(Budget $budget, array $data): int
    {
        return $budget->update($data);
    }

    public function delete(Budget $budget): bool
    {
        return $budget->delete();
    }

    public function find(int $id): ?Budget
    {
        $cacheKey = "budget_{$id}";
        $cacheTime = 10;

        return Cache::remember($cacheKey, now()->addMinutes($cacheTime), function () use ($id) {
            return Budget::with([
                'user:id,name,email',
                'category:id,name,type'
            ])->find($id);
        });
    }
}
