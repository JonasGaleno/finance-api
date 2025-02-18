<?php

namespace App\Services;

use App\Models\Transaction;
use App\Repositories\TransactionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    public function __construct(
        protected TransactionRepositoryInterface $transactionRepository
    ) {
    }

    public function all(Request $request): LengthAwarePaginator
    {
        $transactions = $this->transactionRepository->all($request);

        if ($transactions->isEmpty()) {
            throw new \Exception('Transactions not found', 204);
        }

        return $transactions;
    }

    public function register(array $data): Transaction
    {
        return DB::transaction(function () use ($data) {
            return $this->transactionRepository->register($data);
        });
    }

    public function update(array $data, int $id): Transaction
    {
        return DB::transaction(function () use ($data, $id) {
            $transaction = $this->transactionRepository->find($id);

            if (!$transaction) {
                throw new \Exception('Transaction not found', 400);
            }

            $this->transactionRepository->update($transaction, $data);

            return $this->transactionRepository->find($id);
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $transaction = $this->transactionRepository->find($id);

            if (!$transaction) {
                throw new \Exception('Transaction not found', 400);
            }

            $transactionRemoved = $this->transactionRepository->delete($transaction);

            if (!$transactionRemoved) {
                throw new \Exception('An error occurred while removing the transaction');
            }

            return $transactionRemoved;
        });
    }

    public function find(int $id): Transaction
    {
        $transaction = $this->transactionRepository->find($id);

        if (!$transaction) {
            throw new \Exception('Transaction not found', 400);
        }

        return $transaction;
    }
}
