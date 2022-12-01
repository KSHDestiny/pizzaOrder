<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RouteController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// get
Route::get('list',[RouteController::class,'list']);
Route::get('category/list',[RouteController::class,'categoryList']);


// create
Route::post('create/category',[RouteController::class,'categoryCreate']);
Route::post('create/contact',[RouteController::class,'createContact']);

// delete
Route::post('delete/category',[RouteController::class,'categoryDelete']);
Route::get('delete/contact/{id}',[RouteController::class,'deleteContact']);

// view category details
Route::get('category/details/{id}',[RouteController::class,'categoryDetails']);

// category update
Route::post('category/update',[RouteController::class,'categoryUpdate']);
