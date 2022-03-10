<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserManageController extends Controller
{
    public function index()
    {
        $user=User::all();
        return response()->json([$user]);
    }
    public function create()
    {
        $user=User::all();
        return response()->json([$user]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name' => 'required|string',//name is required and should be a string
            'email' => 'required|email|unique:users,email|string',//email required, a string and must be unique from the users table, email column
            'phone_number'=>'required|max:10',//phone number required, maximum 10 characters
            'password' => 'min:6|string|required_with:password_confirmation|same:password_confirmation',//password, required minimum 6 string characters with a confirmation
            'password_confirmation' => 'required|min:6',//the confirmation requireds
        ]);

        if($validator->fails()){
            //throw back any errors of validation if they arise
            return response(['errors'=>$validator->errors()->all()], 422);  
        }


        $role=Role::where('name','=','user')->first();



        $user=User::create([
            'role_id'=>$role->id,
            'name'=>$request->name,
            'email'=>$request->email,
            'phone_number'=>$request->phone_number,
            'password'=>Hash::make($request->password)
        ]);
        if($user){
            return response()->json(['user created succesfully','user'=>$user]);
        }
    }
    public function show($id)
    {
        $user=User::find($id);
        return response()->json([ $user]); 
    }
    public function edit($id)
    {
        $user=User::find($id);
        return response()->json([ $user]); 
    }
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [

            'name' => 'required|string',//name is required and should be a string
            'email' => 'required|email|unique:users,email|string',//email required, a string and must be unique from the users table, email column
            'phone_number'=>'required|max:10',//phone number required, maximum 10 characters
            'password' => 'min:6|string|required_with:password_confirmation|same:password_confirmation',//password, required minimum 6 string characters with a confirmation
            'password_confirmation' => 'required|min:6',//the confirmation requireds
        ]);

        if($validator->fails()){
            //throw back any errors of validation if they arise
            return response(['errors'=>$validator->errors()->all()], 422);  
        }


        $role=Role::where('name','=','user')->first();
        $user=User::create([
            'role_id'=>$role->id,
            'name'=>$request->name,
            'email'=>$request->email,
            'phone_number'=>$request->phone_number,
            'password'=>Hash::make($request->password)
        ]);
        if($user){
            return response()->json(['user created succesfully','user'=>$user]);
        }

    }
    public function destroy($id)
    {
        $user=User::findOrFail($id);
        $result=$user->delete();//will delete the role
 
        if($result){
            return response()->json([$user->name,'deleted succesfully']);
        }

    }
}
