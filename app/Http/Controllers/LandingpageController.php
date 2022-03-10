<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class LandingpageController extends Controller
{
    public function landingPage()
    {
        $project=Project::all();
        $user = Auth::user();
        if($user){
            return response()->json($project);
        }
        else{
            return response()->json(['message'=>['You are not authorised']]);
        }
    }
}
