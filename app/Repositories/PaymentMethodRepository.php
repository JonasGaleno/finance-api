<?php

namespace App\Repositories;

use App\Models\PaymentMethod;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PaymentMethodRepository implements PaymentMethodRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator
    {
        $filters = $request->query();
        $cacheKey = "payment_methods_" . md5(json_encode($filters));
        $cacheTime = 10;

        return Cache::remember($cacheKey, now()->addMinutes($cacheTime), function () use ($request) {
            $query = PaymentMethod::with(['user:id,name,email']);

            // Filtros
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

            return $query->paginate($perPage);
        });
    }

    public function register(array $data): ?PaymentMethod
    {
        return PaymentMethod::create($data)->load(['user:id,name,email']); // Eager loading
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
        $cacheKey = "payment_method_{$id}";
        $cacheTime = 10;

        return Cache::remember($cacheKey, now()->addMinutes($cacheTime), function () use ($id) {
            return PaymentMethod::with(['user:id,name,email'])->find($id);
        });
    }
}
