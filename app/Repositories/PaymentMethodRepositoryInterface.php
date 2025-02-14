<?php

namespace App\Repositories;

use App\Models\PaymentMethod;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface PaymentMethodRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator;

    public function register(array $data): ?PaymentMethod;

    public function update(PaymentMethod $paymentMethod, array $data): int;

    public function delete(PaymentMethod $paymentMethod): bool;

    public function find(int $id): ?PaymentMethod;
}
