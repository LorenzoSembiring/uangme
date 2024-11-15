<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class BorrowerController extends Controller
{
    public function loanLimit(Request $request) {
        try {
            $user = auth()->user();

            if ($user->role == "lender") {
                return response()->json([
                    'code' => 400,
                    'status' => 'bad request',
                    'message' => "your role is not suitable to perform this action"
                ], 400);
            }

            $income = $user->monthly_income;
            $limit = $income * 0.3;

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'data' => [
                    'limit' => $limit,
                ],
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
}
