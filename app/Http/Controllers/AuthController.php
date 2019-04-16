<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
Use App\User;

class AuthController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(Request $request){
        $credentials=$request->only(['email','password']);
        $token=auth()->attempt($credentials);

        if(!$token){
            return response()->json([
                'message'=>'Please check credentials and try again.'
            ],401);
        }
        return response()->json([
            'token'=>$token,
            'type'=>'Bearer',
            'expires_in'=>auth()->factory()->getTTL()*60,
            'user'=>auth()->user()
        ]);
    }


    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
    public function register(RegisterRequest $request){
        $user=new User();
        $user->first_name=$request->input('first_name');
        $user->last_name=$request->input('last_name');
        $user->email=$request->input('email');
        $user->password=bcrypt($request->input('password'));
        $user->save();

        return $this->login($request);
    }
}
