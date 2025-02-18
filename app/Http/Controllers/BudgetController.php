<?php

namespace App\Http\Controllers;

use App\Http\Requests\BudgetRegisterRequest;
use App\Services\BudgetService;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function __construct(
        protected BudgetService $budgetService
    ) {
    }

    public function index(Request $request)
    {
        try {
            $budgets = $this->budgetService->all($request);

            return response()->json($budgets, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for budgets',
                'error' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    public function show(int $id)
    {
        try {
            $budget = $this->budgetService->find($id);

            return response()->json($budget, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for budget',
                'error' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    public function store(BudgetRegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $budget = $this->budgetService->register($validatedData);

            return response()->json($budget, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(BudgetRegisterRequest $request, int $id)
    {
        try {
            $validatedData = $request->validated();

            $budget = $this->budgetService->update($validatedData, $id);

            return response()->json($budget, 200);
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
            $this->budgetService->delete($id);

            return response()->json(['message' => 'Budget deleted'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
