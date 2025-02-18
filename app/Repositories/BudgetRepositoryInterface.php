<?php

namespace App\Repositories;

use App\Models\Budget;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface BudgetRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator;

    public function register(array $data): ?Budget;

    public function update(Budget $budget, array $data): int;

    public function delete(Budget $budget): bool;

    public function find(int $id): ?Budget;
}
