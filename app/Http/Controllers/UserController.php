<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
         // Validation of the user data 
         $validator = Validator::make($request->all(), [

            'name' => 'required|string',//name is required and should be a string
            'email' => 'required|email|unique:users,email|string',//email required, a string and must be unique from the users table, email column
            'phone_number'=>'required|max:10',//phone number required, maximum 10 characters
            'password' => 'min:6|string|required_with:password_confirmation|same:password_confirmation',//password, required minimum 6 string characters with a confirmation
            'password_confirmation' => 'required|min:6'//the confirmation requireds
        ]);

        if($validator->fails()){
            //throw back any errors of validation if they arise
            return response(['errors'=>$validator->errors()->all()], 422);  
            //return ["status"=>"validation unsuccesfull"];   
        }

        $role=Role::where('name','=','user')->first();

        // $role=DB::table('roles')->where('name','user');


        // return response()->json($role->id);

        $user=User::create([
            'role_id'=>$role->id,
            'name'=>$request->name,
            'email'=>$request->email,
            'phone_number'=>$request->phone_number,
            'password'=>Hash::make($request->password),
        ]);

        $token=$user->createToken(time())->accessToken;
        return response()->json(['token'=>$token,'user'=>$user]);

    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);


        if($validator->fails()){
            //throw back ajson error
            return response()->json(['error' => $validator->errors()->all()]);
        }
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            //$user=new User;
            $success=$user->createToken(time())->accessToken;
            return response()->json(['success'=>$success,'user'=>$user]); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }
    public function details()
    {
        $user=Auth::user();
        return response()->json($user);
    }
}
