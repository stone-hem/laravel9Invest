<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;

class GoogleController extends Controller
{
    public function getLoginPage()
    {
        return Socialite::driver('google')->redirect();
    }
    public function userValidate(Request $request)
    {
        $google_id=Socialite::driver('google')->user();
        $user = User::where('google_id', $google_id->id)->first();
 
        if ($user) {
            $user->update([
                'name' => $request->name,
            ]);
            config(['auth.guards.api.provider' => 'user']);// configure to user scope
            $token = $user->createToken(time(),['user'])->accessToken;//create access token using password,and update scope
           return response()->json(['user'=>$user,'token' => $token], 200);//return user login details
           Auth::login($user);

        }
        else{
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'google_id' =>'required',
            'password' => 'required|string|min:6',
            'token'=>'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
   

    

        $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'google_id' =>$request->google_id,
                'password' =>$request->password
        ]);
        config(['auth.guards.api.provider' => 'user']);// configure to user scope
        $token = $user->createToken(time(),['user'])->accessToken;//create access token using password,and update scope
       return response()->json(['user'=>$user,'token' => $token,'message' => 'User successfully validated',], 200);//return user login details
       Auth::login($user);
        Auth::login($user);
    }
        
    }
}
