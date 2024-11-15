<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string',
            'phone_number' => 'required|string',
            'ktp_number' => 'required|string|unique:users',
            'ktp_photo' => 'nullable|image|max:2048',
            'npwp' => 'nullable|string|unique:users',
            'monthly_income' => 'required|numeric|min:0',
            'role' => 'required|in:lender,borrower',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $userData = $request->all();
        $userData['password'] = Hash::make($request->password);

        if ($request->hasFile('ktp_photo')) {
            $userData['ktp_photo'] = $request->file('ktp_photo')->store('ktp_photos');
        }

        $user = User::create($userData);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('phone_number', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user = auth()->user();

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }


    /**
     * Logout the user (invalidate the token).
     */
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'User successfully logged out']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not log out user'], 500);
        }
    }

    /**
     * Get the authenticated user.
     */
    public function me()
    {
        return response()->json(auth()->user());
    }
}
