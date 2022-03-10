<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RolesPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,$permissions)
    {

        $permissions_array = explode('|', $permissions);
        foreach($permissions_array as $permission){
            if (!$request->user()->hasPermission($permission)){
                return response()->json(['unauthorised'=>'request not known']);                        
            }
        }    
        return $next($request);
        if(is_null($request->user())){
            abort(404);
        }
    }
}
