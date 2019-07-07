<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    public function register(Request $request)
    {
        $email = $request->input('email');
        $password = Hash::make($request->input('password'));

        $register = User::create([
            'email' => $email,
            'password' => $password
        ]);

        if($register){
            return response()->json([
                'success' => true,
                'message' => "Register sukses",
                'data' => $register
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => "Register gagal",
                'data' => ''
            ], 400);
        }
    }


    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();
        
        if(Hash::check($password, $user->password)){
            $apiToken = base64_encode(str_random(40));
            $user->update([
                'api_token' => $apiToken
            ]);

            return response()->json([
                'success' => true,
                'message' => "Login sukses",
                'data' => [
                    'user' => $user,
                    'api_token' => $apiToken
                ]
            ], 201);
        }else{
            return response()->json([
                'success' => true,
                'message' => "Login gagal",
                'data' => ''
            ], 401);
        }
    }
}
