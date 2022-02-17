<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\docterController;
use App\Http\Controllers\userController;
use App\Http\Controllers\campController;
use App\Http\Controllers\processeController;
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

//Route::middleware('auth:sanctum')->get("/showdocters",[docterController::class,'showdocters']);

//With auth token
Route::group(['middleware' => 'auth:sanctum'], function(){

    //Docters apis
    Route::get("/showdocters",[docterController::class,'showdocters']);
    Route::get("/showdocter/{docter_id}",[docterController::class,'showdocter']);
    Route::post("/insertdocters",[docterController::class,'insertdocters']);
    Route::post("/updatedocter",[docterController::class,'updatedocter']);
    Route::get("/deletedocter/{docter_id}",[docterController::class,'deletedocter']);

    //Camps apis
    Route::get("/showcamps",[campController::class,'showcamps']);
    Route::get("/showcamp/{camp_id}",[campController::class,'showcamp']);
    Route::post("/insertcamps",[campController::class,'insertcamps']);
    Route::post("/updatecamp",[campController::class,'updatcamp']);
    Route::get("/deletecamp/{camp_id}",[campController::class,'deletecamp']);

    //processes apis
    Route::get("/showprocesses",[processeController::class,'showprocesses']);
    Route::get("/showprocess/{process_id}",[processeController::class,'showprocess']);
    Route::post("/insertprocess",[processeController::class,'insertprocess']);
    Route::post("/updateprocess",[processeController::class,'updateprocess']);
    Route::get("/deleteprocess/{process_id}",[processeController::class,'deleteprocess']);

    //Users apis
    Route::get("/showusers",[userController::class,'showusers']);
    Route::get("/showuser/{id}",[userController::class,'showuser']);
    Route::post("/insertuser",[userController::class,'insertuser']);
    Route::post("/updateuser",[userController::class,'updateuser']);
    Route::get("/deleteuser/{id}",[userController::class,'deleteuser']);

    //Admin apis
    Route::get("/showadmins",[userController::class,'showadmins']);
    Route::get("/showadmin/{id}",[userController::class,'showadmin']);
    Route::post("/insertadmin",[userController::class,'insertadmin']);
    Route::post("/updateadmin",[userController::class,'updateadmin']);
    //Route::get("/deleteuser/{id}",[userController::class,'deleteuser']);

});
//With auth token

Route::post("/login",[userController::class,'login']);