<?php

namespace App\Repositories;

use App\Models\FinancialGoal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;


class FinancialGoalRepository implements FinancialGoalRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator
    {
        // Filtros
        $query = FinancialGoal::query();

        if ($request->has('name') && !empty($request->name)) {
            $query->where('name', $request->name);
        }

        if ($request->has('user_id') && !empty($request->user_id)) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('target_amount') && !empty($request->target_amount)) {
            $query->where('target_amount', $request->target_amount);
        }

        if ($request->has('current_amount') && !empty($request->current_amount)) {
            $query->where('current_amount', $request->current_amount);
        }

        if ($request->has('deadline_date') && !empty($request->deadline_date)) {
            $query->where('deadline_date', $request->deadline_date);
        }

        // Ordenação
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');

        $query->orderBy($sortBy, $sortDirection);

        // Paginação
        $perPage = $request->input('per_page', 10);
        $financialGoals = $query->paginate($perPage);

        return $financialGoals;
    }

    public function register(array $data): ?FinancialGoal
    {
        return FinancialGoal::create($data);
    }

    public function update(FinancialGoal $financialGoal, array $data): int
    {
        return $financialGoal->update($data);
    }

    public function delete(FinancialGoal $financialGoal): bool
    {
        return $financialGoal->delete();
    }

    public function find(int $id): ?FinancialGoal
    {
        return FinancialGoal::find($id);
    }
}
