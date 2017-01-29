<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['guest']], function () {
    Route::get('login', 'UserController@getLogin');
    Route::post('login', 'UserController@authenticateUser');

    Route::get('register', 'UserController@getRegister');
    Route::post('register', 'UserController@storeUser');

    Route::get('email/confirmation', 'UserController@confirmEmail');
    Route::get('email/confirmation/send/{email}', 'UserController@sendConfirmationEmail');

    Route::get('password/reset', 'PasswordController@getEmail');
    Route::post('password/email', 'PasswordController@postEmail');

    Route::get('password/reset/{token}', 'PasswordController@getReset');
    Route::post('password/reset', 'PasswordController@postReset');
});

// The user needs to be authenticated to perform these actions
Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', 'IndexController@getDashboard')
        ->name('dashboard');

    Route::get('dashboard/settings', 'IndexController@getWizardDashboard');

    Route::get('dashboard/classes', 'IndexController@getClassesDashboard');
    Route::get('dashboard/classes/{classId}', 'IndexController@getClassDashboard');
    Route::get('dashboard/classes/{classId}/create', function($classId) {
        return redirect('dashboard/classes/' . $classId)->with('create', true);
    });

    Route::get('dashboard/classes/{classId}/duplicate', function(ClassController $classController, $classId) {
        $classId = $classController->duplicateClass($classId);

        return redirect('dashboard/classes/' . $classId);
    });

    Route::get('logout', 'UserController@getLogout');

    Route::get('class/clear/{id}', 'ClassController@clearSeatingPlan');
    Route::post('class', 'ClassController@storeClass');
    Route::delete('class', 'ClassController@deleteClass');
});

