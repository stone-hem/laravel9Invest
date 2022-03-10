<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class ProfileController extends Controller
{
    public function show()
    {
        $user=User::all();
        $user = Auth::user(); //fetch the data of the currently logged in user
        $success =  $user;//store the fetched details in success variable
        return response()->json($success, 200);//return a json format user details

    }
    public function edit($id)
    {
        $user=User::find($id);
        return response()->json([$user]);
    }
    public function update(Request $request, $id)
    {

        $validator=Validator::make($request->all(),[
            'firstName'=>'required|string',
            'lastName'=>'string|required',
            'phone_number'=>'required|max:10',
            'email'=>'required|email',
            'citizenship'=>'required|string',
            'copyOfID'=>'required|mimes:doc,docx,pdf,png,jpeg,jpg',
            'CopyOfKraPin'=>'required|mimes:doc,docx,pdf,png,jpeg,jpg',
            'profileImage'=>'mimes:png,jpeg.jpg',
        ]);
        if($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 400);
        }

        $user = User::find($id);

        if($user){
            if($request->hasFile('copyOfID')){ //if the user has a file then do...
                $file=$request->file('copyOfID');//request for the file
                $ext=$file->getClientOriginalExtension();//get the orignal extension of the file
                $filename=$user->name.'.'.$ext; //creating a unique filename
                $file->move('assets/copyOfID',$filename);//move the file to the server by creating its path
                $user->copyOfID=$filename;//storing the file name
            }
            if($request->hasFile('CopyOfKraPin')){ //if the user has a file then do...
                $file=$request->file('CopyOfKraPin');//request for the file
                $ext=$file->getClientOriginalExtension();//get the orignal extension of the file
                $filename=$user->name.'.'.$ext; //creating a unique filename
                $file->move('assets/KraCopies',$filename);//move the file to the server by creating its path
                $user->CopyOfKraPin=$filename;//storing the file
            }
            if($request->hasFile('profileImage')){ //if the user has a file then do...
                $file=$request->file('profileImage');//request for the file
                $ext=$file->getClientOriginalExtension();//get the orignal extension of the file
                $filename=$user->name.'.'.$ext; //creating a unique filename
                $file->move('assets/profileImages',$filename);//move the file to the server by creating its path
                $user->profileImage=$filename;//storing the file name
            }
    
            $user->firstName=$request->input('firstName'); 
            $user->lastName=$request->input('lastName'); 
            $user->phone_number=$request->input('phone_number'); 
            $user->email=$request->input('email'); 
            $user->citizenship=$request->input('citizenship'); 
            $user->update();
            return response()->json(['Message' => ['Updated succesfully.']], 200);
        }
        else{
            return response()->json(['error' => ['Product not found.']], 200);
        }
    }
    public function changePassword(Request $request,$id)
    {
        $validator=Validator::make($request->all(),[
            'oldPassword'=>'required|string',
            'newPassword' => 'min:6|string|required_with:password_confirmation|same:password_confirmation',//password, required minimum 6 string characters with a confirmation
            'password_confirmation' => 'required|min:6'//the confirmation required
        ]);
        if($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 400);
        } 

        $user= User::find($id);
        // $user=User::where('id',$id)->get();
        $hashedPassword = Auth::user()->password;//get the password of the currently logged in use using the AuthManager

        if($user){
            if(Hash::check($request->get('oldPassword'),$hashedPassword)){//use Hash::check to compare the password hashes, old and new then,go to the inner if...
            if(strcmp($request->get('oldPassword'),$request->get('newPassword'))==0){//compare the new passsword and the old password, they they match then thay cant be same
                return response()->json(['error' => ['The two passwords cannot be the same']]);//return the response that existing and the new cannot be same
            }
            $user->password=$request->get('newPassword');//if above condition satisfied then move on to request for the password into the password field, remember all passwrds have been hashed in the user model
            $user->save(); //svae the hashed password
            return response()->json(['message' => ['password changed succesfully']]);//return response password changed succesfully
        }
        else{
            return response()->json(['error' => ['The provided password does not march with the existing']]); //if no hash chck it does not match with the existing, return this message    
        }
           
           
        }

        else{
            return response()->json(['error' => ['User not found']]);

        }

    }
}
