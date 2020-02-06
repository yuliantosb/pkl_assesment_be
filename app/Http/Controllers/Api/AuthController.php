<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterMail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users',
            'password' => 'required|min:6|confirmed',
            'name' => 'required|string'
        ]);

        $token = Str::random(25);

        $user = new User;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->name = $request->name;
        $user->api_token = hash('sha256', $token);
        $user->save();

        // Mail::to($user->email)->send(new RegisterMail($user));

        return response()->json([
            'type' => 'success',
            'token' => $token,
            'message' => 'Register successfully'
        ], 201);

    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users',
            'password' => 'required|min:6'
        ]);
        
        $token = Str::random(25);
        $user = User::where('email', $request->email)->first();
        
        if (Hash::check($request->password, $user->password)) {
            
            $user->forceFill([
                'api_token' => hash('sha256', $token)
            ])->save();
            
            return response()->json([
                'type' => 'success',
                'message' => 'Login Success',
                'token' => $token
            ], 201);

        }   else {
            return response()->json([
                'type' => 'error',
                'message' => 'Wrong password!'
            ], 422);
        }


    }
}
