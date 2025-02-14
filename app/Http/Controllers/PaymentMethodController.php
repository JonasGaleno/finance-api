<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentMethodRegisterRequest;
use App\Services\PaymentMethodService;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function __construct(
        protected PaymentMethodService $paymentMethodService
    ) {
    }

    public function index(Request $request)
    {
        try {
            $paymentMethods = $this->paymentMethodService->all($request);

            return response()->json($paymentMethods, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for payment methods',
                'error' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    public function show(int $id)
    {
        try {
            $paymentMethod = $this->paymentMethodService->find($id);

            return response()->json($paymentMethod, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for payment method',
                'error' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    public function store(PaymentMethodRegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $paymentMethod = $this->paymentMethodService->register($validatedData);

            return response()->json($paymentMethod, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(PaymentMethodRegisterRequest $request, int $id)
    {
        try {
            $validatedData = $request->validated();

            $paymentMethod = $this->paymentMethodService->update($validatedData, $id);

            return response()->json($paymentMethod, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->paymentMethodService->delete($id);

            return response()->json(['message' => 'Payment method deleted'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
