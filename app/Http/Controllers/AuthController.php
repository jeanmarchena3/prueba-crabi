<?php

namespace App\Http\Controllers;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login (Request $request){
        try {
            $user = User::where('email', '=', $request->email)
                            ->where('password', '=', $request->password)
                            ->get();
            
            if($user->count() === 0){
                return response()->json([
                    "meta" => ["success"=> false, "errors" => "Invalid credentials"],
                ], 401);
            }

            $token = JWTAuth::fromUser($user[0]);

            return response()->json([
                "meta" => ["success"=> true, "errors" => null],
                "data" => ["token" => $token, "minutes_to_expire" => 1440]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "meta" => ["success"=> false, "errors" =>"Invalid credentials"],
            ], 401);
        }
    }
}
