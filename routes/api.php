<?php

use Illuminate\Support\Facades\Route;
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

// Route::middleware('auth:sanctum')->get('/user',
//     function (Request $request) {
//         return $request->user();
//     }
// );
Route::middleware('auth:sanctum')->group(function () {
    //mail send
    Route::post("/sendmail", "MailsController@send");
    //contacts crud
    Route::get('/contacts', "ContactsController@show");
    Route::post("contacts/update", "ContactsController@update");
    Route::post('/contacts/create', "ContactsController@create");
    //views crud

});
Route::get("/signin", "ApiController@signin")->middleware('token');
Route::get("/signup", "ApiController@signup");
