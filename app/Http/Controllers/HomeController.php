<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Clientproject;

class HomeController extends Controller
{
    public function userHome($id)//  user dashboard logic
    {
        // $users = User::all();
        $user = Auth::user(); //fetch the data of the currently looged in user
        $success =  $user;//store the fetched details in success variable
        $id = $user->id;//get the id of the authenticated user
        $activeprojects = Clientproject::where($id,'user_id')->get();
        $shares = Clientproject::where($id,'user_id')->get();
        return response()->json(['user'=>$success,'activeprojects'=>$activeprojects,'shares'=>$shares], 200);//return a json format user details
    }
}
