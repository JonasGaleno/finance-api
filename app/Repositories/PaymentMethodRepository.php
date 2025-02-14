<?php

namespace App\Repositories;

use App\Models\PaymentMethod;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;


class PaymentMethodRepository implements PaymentMethodRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator
    {
        // Filtros
        $query = PaymentMethod::query();

        if ($request->has('name') && !empty($request->name)) {
            $query->where('name', $request->name);
        }

        if ($request->has('user_id') && !empty($request->user_id)) {
            $query->where('user_id', $request->user_id);
        }

        // Ordenação
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');

        $query->orderBy($sortBy, $sortDirection);

        // Paginação
        $perPage = $request->input('per_page', 10);
        $paymentMethods = $query->paginate($perPage);

        return $paymentMethods;
    }

    public function register(array $data): ?PaymentMethod
    {
        return PaymentMethod::create($data);
    }

    public function update(PaymentMethod $paymentMethod, array $data): int
    {
        return $paymentMethod->update($data);
    }

    public function delete(PaymentMethod $paymentMethod): bool
    {
        return $paymentMethod->delete();
    }

    public function find(int $id): ?PaymentMethod
    {
        return PaymentMethod::find($id);
    }
}
