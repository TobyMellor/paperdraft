<?php

use Illuminate\Http\Request;

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

// The user needs to be authenticated to perform these actions
Route::group(['middleware' => ['auth']], function () {
    Route::resource('canvas-item', 'CanvasItemController',
        [
            'only' => [
                'index',  // GET    api/canvas-item
                'store',  // POST   api/canvas-item
                'update', // PUT    api/canvas-item/{canvas-item-id}
                'destroy' // DELETE api/canvas-item/{canvas-item-id}
            ],
        ]
    );

    Route::put('canvas-item', 'CanvasItemController@batchUpdate');     // PUT    api/canvas-item accepts array
    Route::delete('canvas-item', 'CanvasItemController@batchDestroy'); // DELETE api/canvas-item accepts array

    Route::resource('canvas-history', 'CanvasHistoryController',
        [
            'only' => [
                'index', // GET  api/canvas-history
                'store'  // POST api/canvas-history
            ]
        ]
    );

    Route::resource('class-student', 'ClassStudentController',
        [
            'only' => [
                'index',  // GET    api/class-student
                'store',  // POST   api/class-student
                'update', // PUT    api/class-student/{class-student-id}
                'destroy' // DELETE api/class-student/{class-student-id}
            ],
        ]
    );

    Route::resource('student', 'StudentController',
        [
            'only' => [
                'index',  // GET    api/student
                'store',  // POST   api/student
                'update', // PUT    api/student/{student-id}
                'destroy' // DELETE api/student/{student-id}
            ],
        ]
    );

    Route::get('student/gender', 'StudentController@guessGender');
    
    Route::resource('class', 'ClassController', 
        [
            'only' => [
                'store',  // POST   api/class
                'destroy' // DELETE api/class
            ], 
        ]
    );

    Route::resource('user', 'UserController', 
        [
            'only' => [
                'update', // PUT api/user
            ], 
        ]
    );

    Route::resource('institution', 'InstitutionController', 
        [
            'only' => [
                'store', // POST api/institution
            ], 
        ]
    );

    Route::resource('user/setting', 'SettingController',
        [
            'only' => [
                'store',  // POST api/setting
            ],
        ]
    );
});
