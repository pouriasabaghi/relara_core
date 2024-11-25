<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    public function index(): JsonResponse
    {
        $users = User::paginate(30);
        return response()->json($users);
    }


    public function store(UserRequest $request): JsonResponse
    {
        $user = User::create($request->only([
            'email',
            'password',
            'role',
            'name',
            'mobile',
            'national_id',
        ]));

        return response()->json([
            'message' => 'User created',
            'user' => $user,
        ], Response::HTTP_CREATED);

    }

    public function show(string $id): JsonResponse
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(UserRequest $request, string $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->update($request->only([
            'email',
            'password',
            'role',
            'name',
            'mobile',
            'national_id',
        ]));
        return response()->json([
            'message' => 'User updated',
            'user' => $user,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->tokens()->delete();
        $user->delete();
        return response()->json([
            'message' => 'User deleted',
        ]);
    }
}
