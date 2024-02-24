<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
// use App\Mail\ResetPasswordMailable;

class AuthController extends Controller
{
    public function home()
    {
        return view('app');
    }

    // public function register(Request $request)
    // {
    //     $request->validate([
    //         'name' => ['required'],
    //         'email' => ['required', 'email', 'unique:users'],
    //         'phone' => ['required', 'unique:users'],
    //         'random' => ['unique:users'],
    //         'password' => ['required', 'min:6', 'confirmed']
    //     ]);

    //     $random = rand(9999, 99999);

    //     User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'phone' => $request->phone,
    //         'random' => $random,
    //         'password' => Hash::make($request->password)
    //     ]);

    //     return response()->json([
    //         'message' => 'Register request complete',
    //         'status_code' => 200
    //     ], 200);
    // }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => ['required', 'email'],
    //         'password' => ['required']
    //     ]);

    //     $user = User::where('email', $request->email)->first();

    //     if (!$user || !Hash::check($request->password, $user->password)) {
    //         throw ValidationException::withMessages([
    //             'email' => ['The provided credentials are incorrect']
    //         ]);
    //     }

    //     return $user->createToken('Auth Token', ['user'])->accessToken;
    // }

    public function register(Request $request)
    {
        // return $request->all();
        $request->validate([
            'firstname' => ['required'],
            'lastname' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed']
        ]);

        $fullname = $request->firstname . ' ' . $request->lastname;

        $user = User::create([
            'name' => $fullname,
            'email' => $request->email,
            'username' => \Str::uuid(),
            'password' => Hash::make($request->password),
            'user_type' => 'customer',
            'company_type' => 'Customer',
        ]);

        // Generate a personal access token
        $token = $user->createToken('Customer Token')->plainTextToken;

        return response()->json(['token' => $token, 'user_type' => $user->user_type, 'user' => $user, 'message' => 'Customer registered successfully', 'status' => 200], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // Generate a personal access token
            $token = $user->createToken('Customer Token')->plainTextToken;

            return response()->json(['token' => $token, 'user_type' => $user->user_type, 'user' => $user, 'message' => 'User logged in successfully', 'status' => 200], 200);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect']
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
    }

    public function sendToken(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!isset($user->id)) {
            return response()->json([
                'error' => 'User with this email does not exist'
            ], 401);
        }

        $token = \Str::random(5);
        // Mail::to($user)->send(new ResetPasswordMailable($token));

        $passwordReset = new PasswordReset();
        $passwordReset->email = $user->email;
        $passwordReset->token = $token;

        $passwordReset->save();
    }

    public function validateToken(Request $request)
    {
        $passwordReset = PasswordReset::where('token', $request->token)->first();

        if (!isset($passwordReset->email)) {
            return response()->json([
                'error' => 'Invalid Token'
            ], 401);
        }

        $user = User::where('email', $passwordReset->email)->first();

        return response()->json($user, 200);
    }

    public function resetPassword(Request $request)
    {
        $user = User::find($request->user_id);

        $passwordReset = PasswordReset::where('email', $user->email)->first();
        $passwordReset->delete();

        $user->password = bcrypt($request->password);
        $user->save();
    }
}
