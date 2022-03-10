<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\ActiveProjectsController;
use App\Http\Controllers\NewProjectsController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SharesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserManageController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\LinkedinController;
use App\Http\Controllers\ForgotPasswordController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);
Route::get('amal-capital',[ProjectController::class,'landingPage']);


Route::middleware('auth:api')->group(function () {
    #Landing page
   //shows current investment opportunities to unlogged in users


   Route::get('get-details',[UserController::class,'details'])->middleware('can:user');


   #Homepage
   //User homepage
   Route::get('user-home{$id}',[HomeController::class, 'userHome'])->middleware('can:user');





    #profile
   //show a specific user using the id of the selected role
   Route::get('show-profile',[ProfileController::class,'show'])->middleware('can:user');
   //get the editing page for a specific role using the id of the role
   Route::get('edit-profile/{id}',[ProfileController::class,'edit'])->middleware('can:user');
   //update a given role using a specific id
   Route::post('update-profile/{id}',[ProfileController::class,'update'])->middleware('can:user');
   //change password
   Route::post('change-password/{id}',[ProfileController::class,'changePassword'])->middleware('can:user');


      #entity
   //get the create entity page
   Route::get('create-entity',[EntityController::class,'create'])->middleware('can:user');
   //store the newly created entity
   Route::post('store-entity',[EntityController::class,'store'])->middleware('can:user');
   //show a specific entity using the id of the selected role
   Route::get('show-entity/{id}',[EntityController::class,'show'])->middleware('can:user');

  
   

       #Active projects
   //view all active page
   Route::get('view-active-projects',[ActiveProjectsController::class,'index'])->middleware('can:user');
   //show a specific active project using the id of the selected role
   Route::get('show-project/{id}',[ActiveProjectsController::class,'show'])->middleware('can:user');



       #new projects
   //view all new page
   Route::get('view-new-projects',[NewProjectsController::class,'index'])->middleware('can:user');
   //get the create roles page
   Route::get('create-projects/{id}',[NewProjectsController::class,'create'])->middleware('can:user');
   //store the newly created role
   Route::post('store-projects',[NewProjectsController::class,'store'])->middleware('can:user');
   //show a specific role using the id of the selected role
   Route::get('show-projects/{id}',[NewProjectsController::class,'show'])->middleware('can:user');


   #raise capital
   //get the create capitals page
   Route::get('create-capitals',[RoleController::class,'create'])->middleware('can:user');
   //store the newly created role
   Route::post('store-capitals',[RoleController::class,'store'])->middleware('can:user');

 




   #only admin acccess rights routes


   #dashboard
   //admin dashboard
   Route::post('admin-home',[ProjectController::class,'adminDashboard'])->middleware('can:admin');

      #users
   //view all users page
   Route::get('view-users',[UserManageController::class,'index'])->middleware('can:admin');
   //get the create user page
   Route::get('create-users',[UserManageController::class,'create'])->middleware('can:admin');
   //store the newly created user
   Route::post('store-users',[UserManageController::class,'store'])->middleware('can:admin');
   //show a specific user using the id of the selected user
   Route::get('show-user/{id}',[UserManageController::class,'show'])->middleware('can:admin');
   //get the editing page for a specific user using the id of the user
   Route::get('edit-user/{id}',[UserManageController::class,'edit'])->middleware('can:admin');
   //update a given user using a specific id
   Route::post('update-user/{id}',[UserManageController::class,'update'])->middleware('can:admin');
   //delete a given user using the id of the user
   Route::delete('delete-user/{id}',[UserManageController::class,'destroy'])->middleware('can:admin');




         #project management
   //view all projects page
   Route::get('view-projects',[ProjectController::class,'index'])->middleware('can:admin');
   //get the create projects page
   Route::get('create-projects',[ProjectController::class,'create'])->middleware('can:admin');
   //store the newly created project
   Route::post('store-projects',[ProjectController::class,'store'])->middleware('can:admin');
   //show a specific project using the id of the selected project
   Route::get('show-project/{id}',[ProjectController::class,'show'])->middleware('can:admin');
   //get the editing page for a specific project using the id of the project
   Route::get('edit-project/{id}',[ProjectController::class,'edit'])->middleware('can:admin');
   //update a given project using a specific id
   Route::post('update-project/{id}',[ProjectController::class,'update'])->middleware('can:admin');
   //delete a given project using the id of the project
   Route::delete('delete-project/{id}',[ProjectController::class,'destroy'])->middleware('can:admin');




      #shares management
   //view all shares page
   Route::get('view-shares',[SharesController::class,'index'])->middleware('can:admin');
   //get the create Shares page
   Route::get('create-shares',[SharesController::class,'create'])->middleware('can:admin');
   //store the newly created share
   Route::post('store-share',[SharesController::class,'store'])->middleware('can:admin');
   //show a specific share using the id of the selected share
   Route::get('show-share/{id}',[SharesController::class,'show'])->middleware('can:admin');
   //get the editing page for a specific share using the id of the share
   Route::get('edit-share/{id}',[SharesController::class,'edit'])->middleware('can:admin');
   //update a given share using a specific id
   Route::post('update-share/{id}',[SharesController::class,'update'])->middleware('can:admin');
   //delete a given share using the id of the role
   Route::delete('delete-share/{id}',[SharesController::class,'destroy'])->middleware('can:admin');
      //admin valadate shares
      Route::post('validate-shares',[ProjectController::class,'validateMyShares'])->middleware('can:admin');


   #roles
   //view all roles page
   Route::get('view-roles',[RoleController::class,'index'])->middleware('can:admin');
   //get the create roles page
   Route::get('create-role',[RoleController::class,'create'])->middleware('can:admin');
   //store the newly created role
   Route::post('store-role',[RoleController::class,'store'])->middleware('can:admin');
   //show a specific role using the id of the selected role
   Route::get('show-role/{id}',[RoleController::class,'show'])->middleware('can:admin');
   //get the editing page for a specific role using the id of the role
   Route::get('edit-role/{id}',[RoleController::class,'edit'])->middleware('can:admin');
   //update a given role using a specific id
   Route::post('update-role/{id}',[RoleController::class,'update'])->middleware('can:admin');
   //delete a given role using the id of the role
   Route::delete('delete-role/{id}',[RoleController::class,'destroy'])->middleware('can:admin');


});

#socialite base
//get the google login page
Route::get('getgoogle',[GoogleController::class, 'create']);
//post the data from google page. login , register
Route::post('google',[GoogleController::class, 'userValidate']);

//get the linked login page
Route::get('getlinkedin', [LinkedInController::class, 'create']);//not functional
//post the data from linkedin page. login , register
Route::post('linkedin', [LinkedInController::class, 'userValidate']);

//get the facebook page
Route::get('facebook',[FacebookController::class,'userValidate']);//not functional
//post the data from facebook page. login , register
Route::post('facebook',[FacebookController::class,'userValidate']);

//reset password using email reset link
Route::post('password/email', [ForgotPasswordController::class, 'forgot']);
Route::post('password/reset',[ForgotPasswordController::class,'reset']);

Route::group(['middleware' => ['can:publish articles']], function () {
    //
});
