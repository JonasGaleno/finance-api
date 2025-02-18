<?php

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;


class TransactionRepository implements TransactionRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator
    {
        // Filtros
        $query = Transaction::query();

        if ($request->has('description') && !empty($request->description)) {
            $query->where('description', $request->description);
        }

        if ($request->has('user_id') && !empty($request->user_id)) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('payment_method_id') && !empty($request->payment_method_id)) {
            $query->where('payment_method_id', $request->payment_method_id);
        }

        if ($request->has('amount') && !empty($request->amount)) {
            $query->where('amount', $request->amount);
        }

        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);
        }

        if ($request->has('transaction_date') && !empty($request->transaction_date)) {
            $query->where('transaction_date', $request->transaction_date);
        }

        // Ordenação
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');

        $query->orderBy($sortBy, $sortDirection);

        // Paginação
        $perPage = $request->input('per_page', 10);
        $transactions = $query->paginate($perPage);

        return $transactions;
    }

    public function register(array $data): ?Transaction
    {
        return Transaction::create($data);
    }

    public function update(Transaction $transaction, array $data): int
    {
        return $transaction->update($data);
    }

    public function delete(Transaction $transaction): bool
    {
        return $transaction->delete();
    }

    public function find(int $id): ?Transaction
    {
        return Transaction::find($id);
    }
}
