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
                'index',  // GET    canvas-item
                'store',  // POST   canvas-item
                'update', // PUT    canvas-item/{canvas-item-id}
                'destroy' // DELETE canvas-item/{canvas-item-id}
            ],
        ]
    );

    Route::put('canvas-item', 'CanvasItemController@batchUpdate');     // PUT    canvas-item accepts array
    Route::delete('canvas-item', 'CanvasItemController@batchDestroy'); // DELETE canvas-item accepts array

    Route::resource('canvas-history', 'CanvasHistoryController', ['only' => [
        'index', // GET  canvas-history
        'store'  // POST canvas-history
    ]]);

    Route::resource('class-student', 'ClassStudentController',
        [
            'only' => [
                'index',  // GET    class-student
                'store',  // POST   class-student
                'update', // PUT    class-student/{class-student-id}
                'destroy' // DELETE class-student/{class-student-id}
            ],
        ]
    );

    Route::resource('student', 'StudentController',
        [
            'only' => [
                'index',  // GET    student
                'store',  // POST   student
                'update', // PUT    student/{student-id}
                'destroy' // DELETE student/{student-id}
            ],
        ]
    );
    
    Route::resource('class', 'ClassController', 
        [
            'only' => [
                'store',  // POST   class
                'destroy' // DELETE class
            ], 
        ]
    );

    Route::resource('user', 'UserController', 
        [
            'only' => [
                'update', // PUT user
            ], 
        ]
    );
});
