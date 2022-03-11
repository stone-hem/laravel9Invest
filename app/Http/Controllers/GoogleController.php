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
    public function findOrCreateUser(Request $request,$googleid)
    {
        $usercreate=User::where('google_id',$googleid)->first();
        if ($usercreate) {
            return User::where($usercreate);
        }
        else{
            // if (User::where('email',$email)->first();) {
            //     $id=$newuser->id;
            //     Auth::loginUsingId($id);
            // }
           

        }
    }
}
