<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    // login should be improved to return a reponse a message if not authenticated
    // Login failed. Status: 500 
    // Response { type: "cors", url: "http://erpmaster.test/api/login", redirected: false, status: 500, ok: false, statusText: "Internal Server Error", headers: Headers(2), body: ReadableStream, bodyUsed: false }
    // ​
    // body: ReadableStream { locked: true }
    // ​
    // bodyUsed: true
    // ​
    // headers: Headers { "cache-control" → "no-cache, private", "content-type" → "text/html; charset=UTF-8" }
    // ​
    // ok: false
    // ​
    // redirected: false
    // ​
    // status: 500
    // ​
    // statusText: "Internal Server Error"
    // ​
    // type: "cors"
    // ​
    // url: "http://erpmaster.test/api/login"
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], Response::HTTP_UNAUTHORIZED);
        }
        
        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user]);
    }

    public function getUserProfile(Request $request)
    {
        return response()->json($request->user());
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
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(['token' => $token, 'user' => $user]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ]);
        }
    }

    /**
     * Logs out the currently authenticated user.
     *
     * @return JsonResponse The JSON response.
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Logged out successfully']);
    }

    /**
     * Handles token refresh.
     *
     * @param Request $request The request object.
     * @return JsonResponse The JSON response.
     */
    public function refresh(Request $request): JsonResponse
    {
        auth()->logout();
        $token = $request->user()->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
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
            'new_password' => 'required|string|min:8|different:current_password',
        ]);

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return response()->json(['error' => 'Invalid current password'], 401);
        }

        $user->update(['password' => Hash::make($request->input('new_password'))]);

        return response()->json(['message' => 'Password changed successfully']);
    }
}
