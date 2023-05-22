<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;
use Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'c_password' => 'required|same:password',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);
            }
    
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $success =  $user;
            $success['token'] =  $user->createToken('student')->accessToken;
    
            return response()->json($success, 200);
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success = $user;
            $success['token'] =  $user->createToken('student')->accessToken;
            return response()->json($success, 200);
        }
        else{
            return response()->json(['error'=>'Unauthorized Account'], 401);
        }

    }

    public function logout(Request $request){
        $user = Auth::user();
        $user->token()->revoke();
		return response()->json(['message' => 'Successfully logged out']);
    }
}
