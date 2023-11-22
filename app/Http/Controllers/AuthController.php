<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function admin_login(Request $request)
    {
        $credentials = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($credentials->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $credentials->errors()
            ], 422);
        }

        $user = Admin::where('email', $request->email)->first();

        if ($user) {
            if (password_verify($request->password, $user->password)) {
                $user->update([
                    'login_tokens' => $user->makeToken()
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Login Success',
                    'data' => [
                        'user' => $user
                    ]
                ], 200);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized'
        ], 401);
    }

    public function admin_logout(Request $request)
    {
        $user = Admin::where('login_tokens', $request->bearerToken())->first();

        if ($user) {

            $user->update([
                'login_tokens' => null
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Logout Success'
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid Token'
        ], 401);
    }
}
