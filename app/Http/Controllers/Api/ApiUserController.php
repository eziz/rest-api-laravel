<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ApiUserController extends Controller
{
    public function index()
    {
        $user = User::get();

        return response()->json(['message' => 'Sukses', 'data' => $user], 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:4',
            ]
        );

        if ($validate->fails()) {
            return response()->json($validate->errors());
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'user registered ', 'data' => $user], 200);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['message' => 'Hi '.$user->name . ', welcome to home', 'access_token' => $token, 'token_type' => 'Bearer']);
    }
}
