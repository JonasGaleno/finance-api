<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {
    }

    public function index(Request $request)
    {
        try {
            $users = $this->userService->all($request);

            return response()->json($users, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for users',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(int $id)
    {
        try {
            $user = $this->userService->find($id);

            return response()->json($user, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for user',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UserRegisterRequest $request, int $id)
    {
        try {
            $validatedData = $request->validated();

            $user = $this->userService->update($validatedData, $id);

            return response()->json($user, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->userService->delete($id);

            return response()->json(['message' => 'User deleted'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
