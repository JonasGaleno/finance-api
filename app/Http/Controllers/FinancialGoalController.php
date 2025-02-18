<?php

namespace App\Http\Controllers;

use App\Http\Requests\FinancialGoalRegisterRequest;
use App\Services\FinancialGoalService;
use Illuminate\Http\Request;

class FinancialGoalController extends Controller
{
    public function __construct(
        protected FinancialGoalService $financialGoalService
    ) {
    }

    public function index(Request $request)
    {
        try {
            $financialGoals = $this->financialGoalService->all($request);

            return response()->json($financialGoals, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for financial goals',
                'error' => $e->getMessage(),
            ], $e->getCode());
        }
    }
    
    public function show(int $id)
    {
        try {
            $financialGoal = $this->financialGoalService->find($id);

            return response()->json($financialGoal, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for financial goal',
                'error' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    public function store(FinancialGoalRegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $financialGoal = $this->financialGoalService->register($validatedData);

            return response()->json($financialGoal, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(FinancialGoalRegisterRequest $request, int $id)
    {
        try {
            $validatedData = $request->validated();

            $financialGoal = $this->financialGoalService->update($validatedData, $id);

            return response()->json($financialGoal, 200);
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
            $this->financialGoalService->delete($id);

            return response()->json(['message' => 'Financial goal deleted'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
