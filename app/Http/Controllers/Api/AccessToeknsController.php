<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Laravel\Sanctum\PersonalAccessToken;

class AccessToeknsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:225',
            'password' => 'required|string|min:3',
            'device_name' => 'string|max:225',
            'abilities' => 'nullable|array',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $device_name = $request->post('device_name', $request->userAgent());

            $token = $user->createToken($device_name, $request->post('abilities'));
            return Response::json([
                'code' => 1,
                'token' => $token->plainTextToken,
                'user' => $user,
            ], 200);
        }
        return Response::json([
            'code' => 0,
            'message' => 'Invalid Creadentials',
        ], 401);
    }
    public function destroy($token = null)
    {
        /** @var \App\M odels\User $user */
        $user = Auth::guard('sanctum')->user();

        if ($token == null) {
            $user->currentAccessToken()->delete();
            return Response::json([
                'code' => 1,
                'message' => 'Token Deleted Successfully'
            ], 200);
        }

        $personalAccessToken = PersonalAccessToken::findToken($token);

        if (!$personalAccessToken) {
            return Response::json([
                'code' => 0,
                'message' => 'Token Not Found',
            ], 404);
        }

        if ($personalAccessToken->tokenable->is($user)) {
            $personalAccessToken->delete();
            return Response::json([
                'code' => 2,
                'message' => 'Token Deleted Successfully'
            ], 200);
        }

        return Response::json([
            'code' => 0,
            'message' => 'You Are Not Authorized To Delete This Token',
        ], 401);
    }
}
