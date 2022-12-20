<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use \stdClass;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'dui' => 'required|string|max:10|unique:customers',
            'birthday' => 'required|date|max:255',
            'phone' => 'required|string|max:10',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $customer = Customer::create(
            [
                'name' => $request->input("name"),
                'lastname' => $request->input("lastname"),
                'dui' => $request->input("dui"),
                'birthday' => $request->input("birthday"),
                'phone' => $request->input("phone"),
                'email' => $request->input("email"),
                'password' => Hash::make($request->input("password")),
            ]
        );

        $token = $customer->createToken('auth_token')->plainTextToken;

         return response(['customer' => $customer, 'access_token' => $token, 'token_type' => 'Bearer',]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('dui', 'email', 'password'))) {
            return response(["credenciales incorrectas"], 401);
        }


        $customer = Customer::where('email', $request['email'])->firstOrFail();

        $token = $customer->createToken('auth_token')->plainTextToken;

        $cookie = cookie('user', $token, 60 * 24); //token para un dia guardado

        return response([
            'message' => 'Success'
        ])->withCookie($cookie);
    }

    public function user()
    {
        return Auth::user();
    }

    public function logout()
    {
        $cookie = Cookie::forget('user');
        /* $request->user()->tokens()->delete() */
        return response(['message' => 'You hace successfully logged out'])->withCookie($cookie);
    }
}