<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Entity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class EntityController extends Controller
{

    public function create()
    {
        // $entity=Entity::find($id);
        // return response()->json();
        // $entity=Entity::with(relations:'createEntityrelation')->get();
        // return response()->json($entity);
        // dd($entity);
        $user=Auth::user(); 
        $id=$user->id;
        // $user=User::get()->first();

        // $entity=Entity::where('user_id','=','Auth::user()->id');
        $entity=DB::table('entities')->where('user_id',$id)->get();

        return response()->json($entity);

    }
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'directorName'=>'required|string',
            'entityName'=>'string|required',
            'entityPhoneNumber'=>'required|max:10',
            'entityKraPin'=>'string|required',
            'email'=>'required|email',
            'entityAddress'=>'required|string',
            'entitySector'=>'required|string',
            'entityRegNumber'=>'required|string',
            'regDocs'=>'required|mimes:doc,docx,pdf,png,jpeg,jpg',
            'copyOfID'=>'required|mimes:doc,docx,pdf,png,jpeg,jpg',
            'copyKraPin'=>'required|mimes:doc,docx,pdf,png,jpeg,jpg',
            'businessPermit'=>'required|mimes:doc,docx,pdf,png,jpeg,jpg',
        ]);
        if($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 400);
        }
        $user = Auth::user(); //fetch the data of the currently looged in user

        $user=User::get()->first();
        // $onlyid=$user->id;
        // $user = Entity::find($id);    
        $entity= new Entity;
        if($entity){
            if($request->hasFile('regDocs')){ //if the user has a file then do...
                $file=$request->file('regDocs');//request for the file
                $ext=$file->getClientOriginalExtension();//get the orignal extension of the file
                $filename=time().'.'.$ext; //creating a unique filename
                $file->move('assets/registrationDocs',$filename);//move the file to the server by creating its path
                $entity->regDocs=$filename;//storing the file name
            }
            if($request->hasFile('copyOfID')){ //if the user has a file then do...
                // $path='assets/registrationDocs'.$user->regDocs; //decalre the path
                // if(File::exists($path)){//if file exists in the given path then do...
                //     File::delete($path);//do delete the path
                // }
                $file=$request->file('copyOfID');//request for the file
                $ext=$file->getClientOriginalExtension();//get the orignal extension of the file
                $filename=$user->name.'.'.$ext; //creating a unique filename
                $file->move('assets/copyOfId',$filename);//move the file to the server by creating its path
                $entity->copyOfID=$filename;//storing the file name
            }
            if($request->hasFile('copyKraPin')){ //if the user has a file then do...
                // $path='assets/registrationDocs'.$user->regDocs; //decalre the path
                // if(File::exists($path)){//if file exists in the given path then do...
                //     File::delete($path);//do delete the path
                // }
                $file=$request->file('copyKraPin');//request for the file
                $ext=$file->getClientOriginalExtension();//get the orignal extension of the file
                $filename=time().'.'.$ext; //creating a unique filename
                $file->move('assets/KraCopies',$filename);//move the file to the server by creating its path
                $entity->copyKraPin=$filename;//storing the file name
            }
            if($request->hasFile('businessPermit')){ //if the user has a file then do...
                $file=$request->file('businessPermit');//request for the file
                $ext=$file->getClientOriginalExtension();//get the orignal extension of the file
                $filename=time().'.'.$ext; //creating a unique filename
                $file->move('assets/businessPermit',$filename);//move the file to the server by creating its path
                $entity->businessPermit=$filename;//storing the file name
            }


            $entity->user_id=$user->id;
            $entity->directorName=$request->input('directorName'); 
            $entity->entityName=$request->input('entityName'); 
            $entity->entityPhoneNumber=$request->input('entityPhoneNumber'); 
            $entity->entityKraPin=$request->input('entityKraPin');
            $entity->email=$request->input('email');
            $entity->entityAddress=$request->input('entityAddress'); 
            $entity->entitySector=$request->input('entitySector'); 
            $entity->entityRegNumber=$request->input('entityRegNumber'); 
            $result=$entity->save();
            if($result){
                return response()->json(['Message' => ['Updated succesfully.']], 200);
            }

        }
        else{
            return response()->json(['error' => ['Entity not found.']], 200);
        }

    }
    public function show($id)
    {
        $entity=Entity::find($id);
        return response()->json([$entity]);
    }


}
