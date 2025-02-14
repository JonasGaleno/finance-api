<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRegisterRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {
    }

    public function index(Request $request)
    {
        try {
            $categories = $this->categoryService->all($request);

            return response()->json($categories, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for categories',
                'error' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    public function show(int $id)
    {
        try {
            $category = $this->categoryService->find($id);

            return response()->json($category, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for category',
                'error' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    public function store(CategoryRegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $category = $this->categoryService->register($validatedData);

            return response()->json($category, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(CategoryRegisterRequest $request, int $id)
    {
        try {
            $validatedData = $request->validated();

            $category = $this->categoryService->update($validatedData, $id);

            return response()->json($category, 200);
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
            $this->categoryService->delete($id);

            return response()->json(['message' => 'Category deleted'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
