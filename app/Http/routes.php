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

//The user cannot be logged in to perform these actions
Route::group(['middleware' => ['web', 'guest']], function () {
    Route::get('/login', 'UserController@getLogin');
    Route::post('/login', 'UserController@authenticateUser');

    Route::get('/register', 'UserController@getRegister');
    Route::post('/register', 'UserController@storeUser');

    Route::get('email/confirmation', 'UserController@confirmEmail');
    Route::get('email/confirmation/send/{email}', 'UserController@sendConfirmationEmail');

    Route::get('password/reset', 'PasswordController@getEmail');
    Route::post('password/email', 'PasswordController@postEmail');

    Route::get('password/reset/{token}', 'PasswordController@getReset');
    Route::post('password/reset', 'PasswordController@postReset');
});

//The user needs to be authenticated to perform these actions
Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/dashboard', 'IndexController@getDashboard');
    Route::get('/dashboard/classes', 'IndexController@getClassesDashboard');
    Route::get('/dashboard/classes/{classId}', 'IndexController@getClassDashboard');

    Route::get('/logout', 'UserController@getLogout');

    Route::post('/student', 'StudentController@storeStudent');

    Route::put('/class-student', 'StudentController@updateClassStudent');

    Route::get('/item', 'ItemController@getItems');

    Route::post('/class', 'ClassController@storeClass');
    Route::delete('/class', 'ClassController@deleteClass');

    // TODO: Routes should be named /canvas-item for one, /canvas-items for multiple
    Route::post('/canvas-item', 'ItemController@storeCanvasItem');
    Route::get('/canvas-item', 'ItemController@getCanvasItems');
    Route::delete('/canvas-item', 'ItemController@deleteCanvasItems');
});

