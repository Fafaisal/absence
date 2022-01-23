<?php

use Illuminate\Http\Request;
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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');
Route::get('employee', 'EmployeeController@employee')->middleware('jwt.verify');
 
Route::get('employee-owner', 'EmployeeController@productAuth')->middleware('jwt.verify');
Route::post('absence-in', 'AbsenceController@absenceIn')->middleware('jwt.verify');
Route::post('absence-out', 'AbsenceController@absenceOut')->middleware('jwt.verify');
Route::post('get-absence', 'AbsenceController@getAbsenceById')->middleware('jwt.verify');
Route::get('user', 'UserController@getAuthenticatedUser')->middleware('jwt.verify');
Route::any('{path}', function() {
    return response()->json([
        'message' => 'Route not found'
    ], 404);
})->where('path', '.*');