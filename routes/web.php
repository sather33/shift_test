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
    return view('welcome');
});

Auth::routes();
Route::middleware('auth')->group(function () {
    // Route::get('/phpinfo', function () { phpinfo(); });
    // Route::post('/redactor-img-upload', 'RedactorImgUploadController@imgUpload');
    Route::post('/shift_schedule', 'DatesController@shift_schedule');
    Route::get('/weekday', 'SchedulesController@weekday');
    Route::post('/weekday', 'SchedulesController@setWeekday');
    Route::get('/schedule/{year}/{month}/{day}/edit', 'SchedulesController@edit');
    Route::get('/schedule/{year}/{month}/{day}/edit/{admin}', 'SchedulesController@edit');
    Route::post('/schedule/{year}/{month}/{day}', 'SchedulesController@update');
    Route::get('/logout', 'HomeController@logout');
    Route::post('/schedules/check', 'SchedulesController@check');
    Route::post('/calculate_time', 'SchedulesController@calculate_time');
    Route::post('/publish_schedule', 'SchedulesController@publish_schedule');
    Route::get('/admin/schedules', 'SchedulesController@admin_index');
    Route::post('/setting', 'OptionController@save_setting');
    Route::get('/setting', 'OptionController@setting');
    Route::post('/limit', 'OptionController@limit');
    Route::post('/export', 'SchedulesController@export');
});

Route::get('/home', 'HomeController@index')->name('home');
// Route::match(['get', 'post'], '/botman', 'BotManController@handle');
// Route::get('/work', 'DatesController@work');
Route::get('/give_shift/{id}/{month}', 'DatesController@give_shift');
Route::post('/give_shift/{id}/{month}', 'DatesController@save_shift');
Route::get('/schedules', 'SchedulesController@index');
Route::get('/schedules/{month}', 'SchedulesController@show');
Route::post('/schedules_week', 'SchedulesController@schedules_week');
