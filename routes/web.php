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
    Route::get('/ajaxmuser', 'MUserController@ajaxData')->name('/ajaxmuser');
    Route::post('/muser/destroy', 'MUserController@webDestroy');

    Route::get('/mrole', 'MRoleController@webIndex')->name('mrole');
    Route::get('/mrole/create', 'MRoleController@webCreate');
    Route::get('/mrole/edit/{id}', 'MRoleController@webEdit');
    Route::post('/mrole/update', 'MRoleController@webUpdate');
    Route::post('/mrole/store', 'MRoleController@webStore');
    Route::post('/mrole/toggle', 'MRoleController@webToggle');
    Route::get('/ajaxmrole', 'MRoleController@ajaxData')->name('/ajaxmrole');
    Route::post('/mrole/destroy', 'MRoleController@webDestroy');

    Route::get('/mactivity', 'MActivityController@webIndex')->name('mactivity');
    Route::get('/mactivity/display/error', 'MActivityController@webError');
    Route::post('/mactivity/store', 'MActivityController@webStore');
    Route::post('/mactivity/update/{id}', 'MActivityController@webUpdate');
    Route::post('/mactivity/destroy/{id}', 'MActivityController@webDestroy');
    Route::get('/ajaxmactivity', 'MActivityController@ajaxData')->name('/ajaxmactivity');

    Route::get('/mgame', 'MGameController@webIndex')->name('mgame');
    Route::get('/mgame/create', 'MGameController@webCreate');
    Route::post('/mgame/store', 'MGameController@webStore');
    Route::post('/mgame/update', 'MGameController@webUpdate');
    Route::post('/mgame/destroy/{id}', 'MGameController@webDestroy');
    Route::get('/ajaxmgame', 'MGameController@ajaxData')->name('/ajaxmgame');
    Route::get('/mgame/edit/{id}', 'MGameController@webEdit');
    Route::post('/mgame/destroy', 'MGameController@webDestroy');
    Route::post('/mgame/toggle', 'MGameController@webToggle');

    Route::get('/mpromotion', 'MPromotionController@webIndex')->name('mpromotion');
    Route::post('/mpromotion/store', 'MPromotionController@webStore');
    Route::get('/mpromotion/create', 'MPromotionController@webCreate');
    Route::post('/mpromotion/update', 'MPromotionController@webUpdate');
    Route::post('/mpromotion/destroy', 'MPromotionController@webDestroy');
    Route::get('/mpromotion/edit/{id}', 'MPromotionController@webEdit');
    Route::post('/mpromotion/toggle', 'MPromotionController@webToggle');
    Route::get('/mpromotionajax', 'MPromotionController@ajaxData')->name('/mpromotionajax');

    Route::get('/mcalendar', 'MCalendarController@webIndex')->name('mcalendar');
    Route::post('/mcalendar/store', 'MCalendarController@webStore');
    Route::get('/mcalendar/create', 'MCalendarController@webCreate');
    Route::post('/mcalendar/update', 'MCalendarController@webUpdate');
    Route::post('/mcalendar/destroy', 'MCalendarController@webDestroy');
    Route::get('/mcalendar/edit/{id}', 'MCalendarController@webEdit');
    Route::post('/mcalendar/toggle', 'MCalendarController@webToggle');
    Route::get('/mcalendarajax', 'MCalendarController@ajaxData')->name('mcalendarajax');

    Route::get('/marticle', 'MArticleController@webIndex')->name('marticle');
    Route::post('/marticle/store', 'MArticleController@webStore');
    Route::get('/marticle/create', 'MArticleController@webCreate');
    Route::post('/marticle/update', 'MArticleController@webUpdate');
    Route::post('/marticle/destroy', 'MArticleController@webDestroy');
    Route::get('/marticle/edit/{id}', 'MArticleController@webEdit');
    Route::post('/marticle/toggle', 'MArticleController@webToggle');
    Route::get('/marticleajax', 'MArticleController@ajaxData')->name('marticleajax');

    Route::get('/mbanner', 'MBannerController@webIndex')->name('mbanner');
    Route::post('/mbanner/store', 'MBannerController@webStore');
    Route::get('/mbanner/create', 'MBannerController@webCreate');
    Route::post('/mbanner/update', 'MBannerController@webUpdate');
    Route::post('/mbanner/destroy', 'MBannerController@webDestroy');
    Route::get('/mbanner/edit/{id}', 'MBannerController@webEdit');
    Route::post('/mbanner/toggle', 'MBannerController@webToggle');
    Route::get('/mbannerajax', 'MBannerController@ajaxData')->name('mbannerajax');

    Route::get('/mconfiguration', 'MConfigurationController@webIndex')->name('mconfiguration');
    Route::post('/mconfiguration/store', 'MConfigurationController@webStore');
    Route::get('/mconfiguration/create', 'MConfigurationController@webCreate');
    Route::post('/mconfiguration/update', 'MConfigurationController@webUpdate');
    Route::post('/mconfiguration/destroy', 'MConfigurationController@webDestroy');
    Route::get('/mconfiguration/edit/{id}', 'MConfigurationController@webEdit');
    Route::post('/mconfiguration/toggle', 'MConfigurationController@webToggle');
    Route::get('/mconfigurationajax', 'MConfigurationController@ajaxData')->name('mconfigurationajax');
    Route::post('/msmtp/store', 'MConfigurationController@webStoreSmtp');


    Route::get('/mstatic', 'MStaticController@webIndex')->name('mstatic');
    Route::post('/mstatic/store', 'MStaticController@webStore');
    Route::get('/mstatic/create', 'MStaticController@webCreate');
    Route::post('/mstatic/update', 'MStaticController@webUpdate');
    Route::post('/mstatic/destroy', 'MStaticController@webDestroy');
    Route::get('/mstatic/edit/{id}', 'MStaticController@webEdit');
    Route::post('/mstatic/toggle', 'MStaticController@webToggle');
    Route::get('/mstaticajax', 'MStaticController@ajaxData')->name('mstaticajax');


    Route::get('/mfaq', 'MFaqController@webIndex')->name('mfaq');
    Route::post('/mfaq/store', 'MFaqController@webStore');
    Route::get('/mfaq/create', 'MFaqController@webCreate');
    Route::post('/mfaq/update', 'MFaqController@webUpdate');
    Route::post('/mfaq/destroy', 'MFaqController@webDestroy');
    Route::get('/mfaq/edit/{id}', 'MFaqController@webEdit');
    Route::post('/mfaq/toggle', 'MFaqController@webToggle');
    Route::get('/mfaqajax', 'MFaqController@ajaxData')->name('mfaqajax');


    Route::get('/mtemplate', 'MTemplateController@webIndex')->name('mtemplate');
    Route::post('/mtemplate/store', 'MTemplateController@webStore');
    Route::get('/mtemplate/create', 'MTemplateController@webCreate');
    Route::post('/mtemplate/update', 'MTemplateController@webUpdate');
    Route::post('/mtemplate/destroy', 'MTemplateController@webDestroy');
    Route::get('/mtemplate/edit/{id}', 'MTemplateController@webEdit');
    Route::post('/mtemplate/toggle', 'MTemplateController@webToggle');
    Route::get('/mtemplateajax', 'MTemplateController@ajaxData')->name('mtemplateajax');

    Route::get('/mgcenter', 'MGamecenterController@webIndex')->name('mgcenter');
    Route::post('/mgcenter/store', 'MGamecenterController@webStore');
    Route::get('/mgcenter/create', 'MGamecenterController@webCreate');
    Route::post('/mgcenter/update', 'MGamecenterController@webUpdate');
    Route::post('/mgcenter/destroy', 'MGamecenterController@webDestroy');
    Route::get('/mgcenter/edit/{id}', 'MGamecenterController@webEdit');
    Route::post('/mgcenter/toggle', 'MGamecenterController@webToggle');
    Route::get('/mgcenterajax', 'MGamecenterController@ajaxData')->name('mgcenterajax');

    Route::get('/mtheme', 'MThemeController@webIndex')->name('mtheme');
    Route::post('/mtheme/store', 'MThemeController@webStore');
    Route::get('/mtheme/create', 'MThemeController@webCreate');
    Route::post('/mtheme/update', 'MThemeController@webUpdate');
    Route::post('/mtheme/destroy', 'MThemeController@webDestroy');
    Route::get('/mtheme/edit/{id}', 'MThemeController@webEdit');
    Route::post('/mtheme/toggle', 'MThemeController@webToggle');
    Route::get('/mthemeajax', 'MThemeController@ajaxData')->name('mthemeajax');
});
Route::get('/mridecategory', 'MRidecategoryController@webIndex')->name('mridecategory');
Route::post('/mridecategory/store', 'MRidecategoryController@webStore');
Route::get('/mridecategory/create', 'MRidecategoryController@webCreate');
Route::post('/mridecategory/update', 'MRidecategoryController@webUpdate');
Route::post('/mridecategory/destroy', 'MRidecategoryController@webDestroy');
Route::get('/mridecategory/edit/{id}', 'MRidecategoryController@webEdit');
Route::post('/mridecategory/toggle', 'MRidecategoryController@webToggle');
Route::get('/mridecategoryajax', 'MRidecategoryController@ajaxData')->name('mridecategoryajax');
