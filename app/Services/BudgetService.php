<?php

namespace App\Services;

use App\Models\Budget;
use App\Repositories\BudgetRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BudgetService
{
    public function __construct(
        protected BudgetRepositoryInterface $budgetRepository
    ) {
    }

    public function all(Request $request): LengthAwarePaginator
    {
        $budgets = $this->budgetRepository->all($request);

        if ($budgets->isEmpty()) {
            throw new \Exception('Budgets not found', 204);
        }

        return $budgets;
    }

    public function register(array $data): Budget
    {
        return DB::transaction(function () use ($data) {
            return $this->budgetRepository->register($data);
        });
    }

    public function update(array $data, int $id): Budget
    {
        return DB::transaction(function () use ($data, $id) {
            $budget = $this->budgetRepository->find($id);

            if (!$budget) {
                throw new \Exception('Budget not found', 400);
            }

            $this->budgetRepository->update($budget, $data);

            return $this->budgetRepository->find($id);
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $budget = $this->budgetRepository->find($id);

            if (!$budget) {
                throw new \Exception('Budget not found', 400);
            }

            $budgetRemoved = $this->budgetRepository->delete($budget);

            if (!$budgetRemoved) {
                throw new \Exception('An error occurred while removing the budget');
            }

            return $budgetRemoved;
        });
    }

    public function find(int $id): Budget
    {
        $budget = $this->budgetRepository->find($id);

        if (!$budget) {
            throw new \Exception('Budget not found', 400);
        }

        return $budget;
    }
}
