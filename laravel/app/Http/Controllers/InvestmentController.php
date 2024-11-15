<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function add(Request $request) {
        try {
            $user = auth()->user();

            if ($user->role == "borrower") {
                return response()->json([
                    'code' => 400,
                    'status' => 'bad request',
                    'message' => "your role is not suitable to perform this action"
                ], 400);
            }

            $bank = $request->bank;
            if ($bank === "BCA") {
                $va = "1123" . $user->phone_number;
            } elseif ($bank === "BRI") {
                $va = "1124" . $user->phone_number;
            } elseif ($bank === "BNI") {
                $va = "1125" . $user->phone_number;
            } elseif ($bank === "Mandiri") {
                $va = "1126" . $user->phone_number;
            } else {
                return response()->json([
                    'code' => 400,
                    'status' => 'bad request',
                    'message' => "bank not listed"
                ], 400);
            }

            $investment = Investment::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'bank_code' => $request->bank,
                'va_number' => $va,
                'investment_date' => date("Y/m/d")
            ]);

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'data' => $investment
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function total(Request $request) {
        try {
            $user = auth()->user();

            if ($user->role == "borrower") {
                return response()->json([
                    'code' => 400,
                    'status' => 'bad request',
                    'message' => "your role is not suitable to perform this action"
                ], 400);
            }

            $total = Investment::where('user_id', $user->id)->sum('amount');

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'data' => [
                    'total' => $total
                ]
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function history(Request $request) {
        try {
            $user = auth()->user();

            $investments = Investment::where('user_id', $user->id)->get();

            $parsedInvestments = $investments->map(function ($investment) {
                return [
                    'investment_date' => $investment->investment_date,
                    'va_number' => $investment->va_number,
                    'bank_name' => $investment->bank_code,
                    'amount' => $investment->amount
                ];
            });

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'data' => [
                    'investment' => $parsedInvestments
                ]
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
