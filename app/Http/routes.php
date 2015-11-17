<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/dashboard', 'IndexController@getDashboard');
Route::get('/dashboard/classes', 'IndexController@getClassesDashboard');

Route::get('/login', 'UserController@getLogin');
Route::post('/login', 'UserController@authenticateUser');
Route::post('/register', 'UserController@storeUser');
Route::get('/logout', 'UserController@getLogout');

/*
 * Routes used by forms
 */
Route::post('/student', 'StudentController@storeStudent');

// Route::post('/object', 'ObjectController@storeObject');
// Route::post('/class-object', 'ObjectController@storeClassObject');
Route::get('/object', 'ObjectController@getObjects');
Route::get('/class-object', 'ObjectController@getClassObjects');
