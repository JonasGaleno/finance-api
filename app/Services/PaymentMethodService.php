<?php

namespace App\Services;

use App\Models\PaymentMethod;
use App\Repositories\PaymentMethodRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentMethodService
{
    public function __construct(
        protected PaymentMethodRepositoryInterface $paymentMethodRepository
    ) {
    }

    public function all(Request $request): LengthAwarePaginator
    {
        $paymentMethods = $this->paymentMethodRepository->all($request);

        if ($paymentMethods->isEmpty()) {
            throw new \Exception('Payment methods not found', 204);
        }

        return $paymentMethods;
    }

    public function register(array $data): PaymentMethod
    {
        return DB::transaction(function () use ($data) {
            return $this->paymentMethodRepository->register($data);
        });
    }

    public function update(array $data, int $id): PaymentMethod
    {
        return DB::transaction(function () use ($data, $id) {
            $paymentMethod = $this->paymentMethodRepository->find($id);

            if (!$paymentMethod) {
                throw new \Exception('Payment method not found', 400);
            }

            $this->paymentMethodRepository->update($paymentMethod, $data);

            return $this->paymentMethodRepository->find($id);
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $paymentMethod = $this->paymentMethodRepository->find($id);

            if (!$paymentMethod) {
                throw new \Exception('Payment method not found', 400);
            }

            $paymentMethodRemoved = $this->paymentMethodRepository->delete($paymentMethod);

            if (!$paymentMethodRemoved) {
                throw new \Exception('An error occurred while removing the payment method');
            }

            return $paymentMethodRemoved;
        });
    }

    public function find(int $id): PaymentMethod
    {
        $paymentMethod = $this->paymentMethodRepository->find($id);

        if (!$paymentMethod) {
            throw new \Exception('Payment method not found', 400);
        }

        return $paymentMethod;
    }
}
