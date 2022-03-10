<?php

namespace App\Http\Controllers;

use App\Models\Capital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class RaisecapitalController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $id=$user->id;
        $capital=Capital::where($id,'user_id')->get();
        return response()->json([$capital]);
    }
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'firstName'=>'required|string',
            'lastName'=>'string|required',
            'personalPhoneNumber'=>'required|max:10',
            'emailEntity'=>'required|email',
            'idNumberPersonal'=>'required|string',
            'citizenshipPersonal'=>'required|string',
            'citizenshipEntity'=>'required|string',
            'copyOfId'=>'required|mimes:doc,docx,pdf,png,jpeg,jpg',
            'kraPin'=>'required|mimes:doc,docx,pdf,png,jpeg,jpg',
            'directorName'=>'required|string',
            'entityName'=>'string|required',
            'entityPhoneNumber'=>'required|max:10',
            'emailPersonal'=>'required|email',
            'idNumberEntity'=>'required',
            'businessPermit'=>'required|mimes:doc,docx,pdf,png,jpeg,jpg',
            'raiseAmount'=>'required'
        ]);
        if($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 400);
        }
        $user = Auth::user();
        $capital= new Capital;
        if($capital){
            if($request->hasFile('copyOfId')){ //if the user has a file then do...
                $path='assets/registrationDocs'.$user->regDocs; //decalre the path
                if(File::exists($path)){//if file exists in the given path then do...
                    File::delete($path);//do delete the path
                }
                $file=$request->file('copyOfId');//request for the file
                $ext=$file->getClientOriginalExtension();//get the orignal extension of the file
                $filename=time().'.'.$ext; //creating a unique filename
                $file->move('assets/copyOfId',$filename);//move the file to the server by creating its path
                $capital->copyOfId=$filename;//storing the file name
            }
            if($request->hasFile('copyKraPin')){ //if the user has a file then do...
                $path='assets/registrationDocs'.$user->regDocs; //decalre the path
                if(File::exists($path)){//if file exists in the given path then do...
                    File::delete($path);//do delete the path
                }
                $file=$request->file('copyKraPin');//request for the file
                $ext=$file->getClientOriginalExtension();//get the orignal extension of the file
                $filename=time().'.'.$ext; //creating a unique filename
                $file->move('assets/KraCopies',$filename);//move the file to the server by creating its path
                $capital->copyKraPin=$filename;//storing the file name
            }
            if($request->hasFile('businessPermit')){ //if the user has a file then do...
                $path='assets/registrationDocs'.$user->regDocs; //decalre the path
                if(File::exists($path)){//if file exists in the given path then do...
                    File::delete($path);//do delete the path
                }
                $file=$request->file('businessPermit');//request for the file
                $ext=$file->getClientOriginalExtension();//get the orignal extension of the file
                $filename=time().'.'.$ext; //creating a unique filename
                $file->move('assets/businessPermit',$filename);//move the file to the server by creating its path
                $capital->businessPermit=$filename;//storing the file name
            }


            $capital->user_id=$user->id;
            $capital->directorName=$request->input('directorName'); 
            $capital->entityName=$request->input('entityName'); 
            $capital->citizenshipPersonal=$request->input('citizenshipPersonal');
            $capital->idNumberPersonal=$request->input('idNumberPersonal');
            $capital->entityPhoneNumber=$request->input('entityPhoneNumber'); 
            $capital->emailEntity=$request->input('emailEntity');
            $capital->firstName=$request->input('firstName'); 
            $capital->lastName=$request->input('lastName'); 
            $capital->citizenshipEntity=$request->input('citizenshipEntity'); 
            $capital->idNumberEntity=$request->input('idNumberEntity');
            $capital->personalPhoneNumber=$request->input('personalPhoneNumber'); 
            $capital->emailPersonal=$request->input('emailPersonal'); 
            $capital->raiseAmount=$request->input('raiseAmount'); 
            $result=$capital->save();
            if($result){
                return response()->json(['Message' => ['Updated succesfully.']], 200);
            }
    }
}
}
