<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Clientproject;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ActiveProjectsController extends Controller
{
    public function index()
    {
        Auth::user();//instance of the currently authenticated user
        $id = Auth::id();//get the id of the authenticated user
        $activeprojects = Clientproject::where($id,'user_id');
        return response()->json($activeprojects);
    }
    public function show($id)
    {
        $getId=Clientproject::find($id)->where('id','=',$id)->first();
        return response()->json($getId);
    }




    public function investInANewProject(Request $request,$id)
    {
        $validator=Validator::make($request->all(),[
            'myInvestment'=>'required|string',
            'agree'=>'string|required',
        ]);
        if($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 400);
        }
        $user = Auth::user(); //fetch the data of the currently looged in user
        
        $entity=DB::table('entities')->where('user_id',$user->id)->first();

        $user=User::get()->first();

        $project=Project::find($id)->where('id','=',$id)->first();
        
        // $onlyid=$user->id;
        // $user = Entity::find($id);    
        $invest= new Clientproject;
        if($invest){
            $invest->user_id=$user->id;//from the users table
            $invest->projectName=$request->input('projectName'); //from the projects table
            $invest->project_id=$project->id; //from the projects table
            $invest->sector=$entity->entitySector; //from the entities table get the entity sector
            $invest->goalAmount=$project->goalAmount; //from the projects table
            $invest->myInvestment=$request->input('myInvestment');//input as the amount the user will invest
            $invest->percentageStake=$request->input('percentageStake');//will be calculated from?
            $invest->percentageCompletion=$request->input('percentageCompletion'); //will be calculated from?
            $invest->closingDate=$request->input('closingDate'); //dont knoew from where?
            $invest->equityDealType=$request->input('equityDealType')==TRUE?'1':'0';//using ternary operator for checkbox,input from user
            $invest->debtDealType=$request->input('debtDealType')==TRUE?'1':'0';//using ternary operator for checkbox, input from user
            $invest->revenueShareDealType=$request->input('revenueShareDealType')==TRUE?'1':'0';//using ternary operator for checkbox, input from user
            $invest->equityAmount=$request->input('equityAmount'); //input from user
            $invest->debtAmount=$request->input('debtAmount'); //input from user
            $invest->revuenueShareAmount=$request->input('revuenueShareAmount'); //input from user
            $invest->investAsPerson=$request->input('investAsPerson')==TRUE?'1':'0';//using ternary operator for checkbox, input from user
            $invest->investAsLegalEntity=$request->input('investAsLegalEntity')==TRUE?'1':'0';//using ternary operator for checkbox, input from user
            $invest->agree=$request->input('status')==TRUE?'1':'0';//using ternary operator for checkbox, input from user
            $result=$invest->save();
            if($result){
                return response()->json(['Message' => ['Invested succesfull.']], 200);
            }

        }
        else{
            return response()->json(['error' => ['Entity not found.']], 200);
        }

    }
}
