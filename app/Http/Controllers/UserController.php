<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {
    }

    public function index()
    {
        try {
            $users = $this->userService->all();

            return response()->json($users, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro ao buscar os usuários.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
