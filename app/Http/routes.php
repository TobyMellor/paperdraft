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

    Route::post('/class', 'ClassController@storeClass');
    Route::delete('/class', 'ClassController@deleteClass');

    Route::group(['middleware' => ['api']], function () {
        Route::resource('api/canvas-item', 'CanvasItemController',
            [
                'only' => [
                    'index',  // GET     api/canvas-item
                    'store',  // POST    api/canvas-item
                    'update', // PUT     api/canvas-item/{canvas-item-id}
                    'destroy' // DELETE  api/canvas-item/{canvas-item-id}
                ],
            ]
        );

        Route::put('api/canvas-item', 'CanvasItemController@batchUpdate');     // PUT    api/canvas-item accepts array
        Route::delete('api/canvas-item', 'CanvasItemController@batchDestroy'); // DELETE api/canvas-item accepts array

        Route::resource('api/canvas-history', 'CanvasHistoryController', ['only' => [
            'index', // GET  api/canvas-history
            'store'  // POST api/canvas-history
        ]]);

        Route::resource('api/student', 'StudentController',
            [
                'only' => [
                    'index',  // GET     api/student
                    'store',  // POST    api/student
                    'update', // PUT     api/student/{student-id}
                    'destroy' // DELETE  api/student/{student-id}
                ],
            ]
        );
    });
});

