<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ( ! Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'message' => 'Invalid login details',
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user]);
    }

    public function userProfile(Request $request)
    {
        $user = $request->user();
        $userData = new UserResource($user);

        return response()->json($userData);
    }

    /**
     * Handles user registration.
     *
     * @param Request $request The request object.
     * @return JsonResponse The JSON response.
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $user = User::create([
                'name'     => $validatedData['name'],
                'email'    => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(['token' => $token, 'user' => $user]);
        } catch (Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }

    /**
     * Logs out the currently authenticated user.
     *
     * @return JsonResponse The JSON response.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        auth()->logout();

        return response()->json(['message' => 'Logged out successfully']);
    }

    /**
     * Handles password change.
     *
     * @param Request $request The request object.
     * @return JsonResponse The JSON response.
     */
    public function changePassword(Request $request): JsonResponse
    {
        $user = $request->user();

        $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|string|min:8|different:current_password',
        ]);

        if ( ! Hash::check($request->input('current_password'), $user->password)) {
            return response()->json(['error' => 'Invalid current password'], 401);
        }

        $user->update(['password' => Hash::make($request->input('new_password'))]);

        return response()->json(['message' => 'Password changed successfully']);
    }
}
