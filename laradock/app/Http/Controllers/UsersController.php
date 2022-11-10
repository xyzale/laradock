<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct(private readonly UserService $service)
    {
    }

    public function register(Request $request): JsonResponse
    {
        // TODO: do some validation

        try {
            $user = $this->service->registerUser(
                $request->input('name'),
                $request->input('email'),
                $request->input('password')
            );

            return response()->json([
                'user' => $user
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
