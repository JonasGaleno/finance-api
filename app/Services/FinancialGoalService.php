<?php

namespace App\Services;

use App\Models\FinancialGoal;
use App\Repositories\FinancialGoalRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialGoalService
{
    public function __construct(
        protected FinancialGoalRepositoryInterface $financialGoalRepository
    ) {
    }

    public function all(Request $request): LengthAwarePaginator
    {
        $financialGoals = $this->financialGoalRepository->all($request);

        if ($financialGoals->isEmpty()) {
            throw new \Exception('Financial goals not found', 204);
        }

        return $financialGoals;
    }

    public function register(array $data): FinancialGoal
    {
        return DB::transaction(function () use ($data) {
            return $this->financialGoalRepository->register($data);
        });
    }

    public function update(array $data, int $id): FinancialGoal
    {
        return DB::transaction(function () use ($data, $id) {
            $financialGoal = $this->financialGoalRepository->find($id);

            if (!$financialGoal) {
                throw new \Exception('Financial goal not found', 400);
            }

            $this->financialGoalRepository->update($financialGoal, $data);

            return $this->financialGoalRepository->find($id);
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $financialGoal = $this->financialGoalRepository->find($id);

            if (!$financialGoal) {
                throw new \Exception('Financial goal not found', 400);
            }

            $financialGoalRemoved = $this->financialGoalRepository->delete($financialGoal);

            if (!$financialGoalRemoved) {
                throw new \Exception('An error occurred while removing the financial goal');
            }

            return $financialGoalRemoved;
        });
    }

    public function find(int $id): FinancialGoal
    {
        $financialGoal = $this->financialGoalRepository->find($id);

        if (!$financialGoal) {
            throw new \Exception('Financial goal not found', 400);
        }

        return $financialGoal;
    }
}
