<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index()
    {
        $project=Project::all();
        return response()->json([$project]);
    }
    public function create()
    {
        $project=Project::first();
        return response()->json([$project]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'projectName' => 'required|string|min:2|max:100',
            'sector'=>'required',
            'goalAmount'=>'required',
            'minimumInvestment'=>'required',
            'maximumInvestment'=>'required',
            'dealType'=>'required'
        
        ]);
        if($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 400);
        }

        $project= new Project;

        $project->projectName=$request->input('projectName'); 
        $project->sector=$request->input('sector'); 
        $project->goalAmount=$request->input('goalAmount'); 
        $project->minimumInvestment=$request->input('minimumInvestment');
        $project->maximumInvestment=$request->input('maximumInvestment');
        $project->dealType=$request->input('dealType'); 
        $result=$project->save();
        if($result){
            return response()->json(['message'=>'Saved succesfully'],200);
        }
    }
    public function show($id)
    {
        $project=Project::find($id);
        return response()->json([$project]);

    }
    public function edit($id)
    {
        $project=Project::find($id);
        return response()->json([$project]);

    }
    public function update(Request $request, Project $project)
    {
    $input = $request->all();
    $validator = Validator::make($input, [
        'projectName' => 'required|string|min:2|max:100',
            'sector'=>'required',
            'goalAmount'=>'required',
            'minimumInvestment'=>'required',
            'maximumInvestment'=>'required',
            'dealType'=>'required'
    ]);
    if($validator->fails()){
        return $this->sendError('Validation Error.', $validator->errors());   
            
        }
        $project->projectName=$request->input('projectName'); 
        $project->sector=$request->input('sector'); 
        $project->goalAmount=$request->input('goalAmount'); 
        $project->minimumInvestment=$request->input('minimumInvestment');
        $project->maximumInvestment=$request->input('maximumInvestment');
        $project->dealType=$request->input('dealType'); 
        $result=$project->save();
       
        return response()->json([
           "message" => "Project updated successfully.",
           "data" => $project
        ]);
    }
    public function destroy($id){
        $users = User::findOrFail($id);
        $users->delete();
        return response()->json(['message'=>'User deleted successfully'],200);
    }


    public function adminDashboard()//admin dashboard logic 
    {
        $users = User::where('role_id',1);
        $success =  $users;
        return response()->json($success, 200);
    }
}
