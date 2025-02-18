<?php

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface TransactionRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator;

    public function register(array $data): ?Transaction;

    public function update(Transaction $transaction, array $data): int;

    public function delete(Transaction $transaction): bool;

    public function find(int $id): ?Transaction;
}
