<?php

namespace App\Repositories;

use App\Models\FinancialGoal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface FinancialGoalRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator;

    public function register(array $data): ?FinancialGoal;

    public function update(FinancialGoal $financialGoal, array $data): int;

    public function delete(FinancialGoal $financialGoal): bool;

    public function find(int $id): ?FinancialGoal;
}
