<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SharesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'companyName' => 'required|string|min:2|max:100',
            'sector'=>'required',
            'totalShares'=>'required',
            'sharePrices'=>'required',
            'shareOnOffer'=>'required',
            'maxSharesToBuy'=>'required',
            'minSharesToBuy'=>'required',
            'investAs'=>'required'
        
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $newShare= new newShare;
            $newShare->companyName=$request->companyName;
            $newShare->totalShares=$request->totalShares;
            $newShare->sharePrices=$request->sharePrices;
            $newShare->shareOnOffer=$request->shareOnOffer;
            $newShare->maxSharesToBuy=$request->maxSharesToBuy;
            $newShare->minSharesToBuy=$request->minSharesToBuy;
            $newShare->investAs=$request->investAs;
            $result=$newShare->save();

            
            return response()->json(["success", 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, newShare $newShare)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'companyName' => 'required|string|min:2|max:100',
            'sector'=>'required',
            'totalShares'=>'required',
            'sharePrices'=>'required',
            'shareOnOffer'=>'required',
            'maxSharesToBuy'=>'required',
            'minSharesToBuy'=>'required',
            'investAs'=>'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());   
                
            }
            $newShare->companyName=$request->input('companyName');
            $newShare->totalShares=$request->input('totalShares');
            $newShare->sharePrices=$request->input('sharePrices');
            $newShare->shareOnOffer=$request->input('shareOnOffer');
            $newShare->maxSharesToBuy=$request->input('maxSharesToBuy');
            $newShare->minSharesToBuy=$request->input('minSharesToBuy');
            $newShare->investAs=$request->input('investAs');
            $result=$newShare->save();
            return response()->json([
                "success" => true,
    
               "message" => "New share updated successfully.",
               "data" => $newShare
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $newShare=newShare::where('id',$id)->first();
        newShare::where('id',$id)->delete();
        return response()->json(['message'=>'A Share deleted successfully']);
    }
    public function validateMyShares(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            
    
            'shareValue' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $myShare= new myShare;
            
            $myShare->shareValue=$request->shareValue;
            $result=$myShare->save();

            
            return response()->json(["success", 200]);
    
    }
}
