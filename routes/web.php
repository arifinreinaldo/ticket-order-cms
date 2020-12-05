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

Route::get('/', function () {
    if (auth()) {
        return redirect('/home');
    } else {
        return view('auth.login');
    }
});
Route::get('/logout', function () {
    return view('auth.login');
});


Auth::routes();

Route::group([
    'middleware' => ['auth']
], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/muser', 'MUserController@webIndex')->name('muser');
    Route::get('/muser/create', 'MUserController@webCreate');
    Route::get('/muser/edit/{id}', 'MUserController@webEdit');
    Route::post('/muser/update', 'MUserController@webUpdate');
    Route::post('/muser/store', 'MUserController@webStore');
    Route::post('/muser/toggle', 'MUserController@webToggle');
    Route::get('/ajaxmuser', 'MuserController@ajaxData')->name('/ajaxmuser');

    Route::post('/muser/destroy/{id}', 'MUserController@webDestroy');
});
