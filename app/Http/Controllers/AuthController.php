<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){
        $rules = [
            'email'=>'required|email',
            'password'=>'required',
        ];
        $v=Validator::make($request->toArray(),$rules);
        if($v->fails())
            return $this->errorResponse($v->errors(),422);

        $user = User::where('email',$request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password))
            return $this->errorResponse('Wrong user or password.',403);

        try {
            $token = $user->createToken();
        } catch(\Error $e) {
            return $this->errorResponse('Token creation failed, check if Passport is configured correctly.',403);

        } catch(\Throwable $e) {
            return $this->errorResponse('Token creation failed, check if Passport is configured correctly.',403);
        }

        return $this->showMessage([
            'user'=>$user,
            'token' => $token
        ]);
    }
}
