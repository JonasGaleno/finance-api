<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRegisterRequest;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionService $transactionService
    ) {
    }

    public function index(Request $request)
    {
        try {
            $transactions = $this->transactionService->all($request);

            return response()->json($transactions, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for transactions',
                'error' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    public function show(int $id)
    {
        try {
            $transaction = $this->transactionService->find($id);

            return response()->json($transaction, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for transaction',
                'error' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    public function store(TransactionRegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $transaction = $this->transactionService->register($validatedData);

            return response()->json($transaction, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(TransactionRegisterRequest $request, int $id)
    {
        try {
            $validatedData = $request->validated();

            $transaction = $this->transactionService->update($validatedData, $id);

            return response()->json($transaction, 200);
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
            $this->transactionService->delete($id);

            return response()->json(['message' => 'Transaction method deleted'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
