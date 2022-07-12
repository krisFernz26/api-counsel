<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $data['email'])->where('role_id', '<>', 1)->where('role_id', '<>', 2)->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response([
                'msg' => 'incorrect email or password'
            ], 401);
        }

        $token = $user->createToken('apiToken')->plainTextToken;

        $user->load('institution');

        $res = [
            'token' => $token,
            'user' => $user,
        ];

        return response($res, 201);
    }

    public function loginAdmin(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $data['email'])->where('role_id', 1)->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response([
                'msg' => 'incorrect email or password'
            ], 401);
        }

        $token = $user->createToken('apiToken')->plainTextToken;

        $user->load('institution');

        $res = [
            'token' => $token,
            'user' => $user,
        ];

        return response($res, 201);
    }

    public function loginInstitution(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $data['email'])->where('role_id', 2)->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response([
                'msg' => 'incorrect email or password'
            ], 401);
        }

        $token = $user->createToken('apiToken')->plainTextToken;

        $user->load('institution');

        $res = [
            'token' => $token,
            'user' => $user,
        ];

        return response($res, 201);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'User logged out'
        ];
    }

    public function validateToken(Request $request)
    {
        $token = PersonalAccessToken::findToken($request->bearerToken());
        $data = [
            'token' => $request->bearerToken(),
            'user' => $token->tokenable
        ];
        return response($data, 200);
    }
}
