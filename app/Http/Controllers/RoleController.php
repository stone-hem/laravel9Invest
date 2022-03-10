<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role=Role::first();
        $permissions=$role->permissions;
        return response()->json(['role'=>$role,'permissions'=>$permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role=Role::all();
        $permissions=$role->permissions;
        return response()->json(['roles'=>$role,'permissions'=>$permissions]);
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

            'name' => 'required|string',//name is required and should be a string
            'roles_permissions' => 'required',
        ]);

        if($validator->fails()){
            //throw back any errors of validation if they arise
            return response(['errors'=>$validator->errors()->all()], 422);  
        }

        // $role=Role::create([
        //     'name'=>$request->name,
        //     'permissions'=>implode(['.',(array)$request->get('permissions')]),
        // ]);

        $role = new Role();
        $role->name = $request->name;
        $role-> save();
       
        // $attach=Role::latest('created_at')->first();

        $listOfPermissions = explode(',', $request->roles_permissions);//create array from separated/coma permissions

        foreach ($listOfPermissions as $permission) {
            $permissions = new Permission();//creating new instance of Permissions for the given role
            $permissions->name = $permission;//storing the selected permissions
            $permissions->save();//
            $role->permissions()->attach($permissions->id);
            $result= $role->save();
        }    

        return response()->json(['found!','role'=>$result]);
        // $result=$role-> save();

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role=Role::find($id);
        return response()->json(['roles'=>$role]);

        //show all permissions the role has

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role=Role::find($id);
        return response()->json(['roles'=>$role]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role=Role::find($id);
        $validator = Validator::make($request->all(), [

            'name' => 'required|string',//name is required and should be a string
            'roles_permissions' => 'required',
        ]);

        if($validator->fails()){
            //throw back any errors of validation if they arise
            return response(['errors'=>$validator->errors()->all()], 422);  
        }

        // $role=Role::create([
        //     'name'=>$request->name,
        //     'permissions'=>implode(['.',(array)$request->get('permissions')]),
        // ]);

        $role = new Role();
        $role->name = $request->name;
        $role-> save();
       
        // $attach=Role::latest('created_at')->first();

        $listOfPermissions = explode(',', $request->roles_permissions);//create array from separated/coma permissions

        foreach ($listOfPermissions as $permission) {
            $permissions = new Permission();//creating new instance of Permissions for the given role
            $permissions->name = $permission;//storing the selected permissions
            $permissions->save();//
            $role->permissions()->attach($permissions->id);
            $result= $role->save();
        }    

        return response()->json(['found!','role'=>$result]);
        $result=$role-> save();


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role=Role::find($id);
        $role->permissions()->delete();//will delete the permissions associated with the role
        $role->delete();//will delete the role
        $result=$role->permissions()->detach();//will detach hence delete intries from the pivot table

        if($result){
            return response()->json([$role->name,'deleted succesfully']);
        }

    }
}
