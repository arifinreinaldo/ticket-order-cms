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
    Route::get('/noauth', 'HomeController@noauth')->name('noauth');
});
Route::group([
    'middleware' => ['auth', 'rolecheck']
], function () {

    Route::get('/muser', 'MUserController@webIndex')->name('muser');
    Route::get('/muser/create', 'MUserController@webCreate');
    Route::get('/muser/edit/{id}', 'MUserController@webEdit');
    Route::post('/muser/update', 'MUserController@webUpdate');
    Route::post('/muser/store', 'MUserController@webStore');
    Route::post('/muser/toggle', 'MUserController@webToggle');
    Route::get('/ajaxmuser', 'MuserController@ajaxData')->name('/ajaxmuser');
    Route::post('/muser/destroy/{id}', 'MUserController@webDestroy');

    Route::get('/mrole', 'MRoleController@webIndex')->name('mrole');
    Route::get('/mrole/create', 'MRoleController@webCreate');
    Route::get('/mrole/edit/{id}', 'MRoleController@webEdit');
    Route::post('/mrole/update', 'MRoleController@webUpdate');
    Route::post('/mrole/store', 'MRoleController@webStore');
    Route::post('/mrole/toggle', 'MRoleController@webToggle');
    Route::get('/ajaxmrole', 'MRoleController@ajaxData')->name('/ajaxmrole');
});
//Route::get('/mmenurole', 'MMenuRoleController@webIndex')->name('mmenurole');
//Route::post('/mmenurole/store', 'MMenuRoleController@webStore');
//Route::post('/mmenurole/update/{id}', 'MMenuRoleController@webUpdate');
//Route::post('/mmenurole/destroy/{id}', 'MMenuRoleController@webDestroy');
