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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
Auth::routes();
Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'SubmissionController@dashboard')->name('dashboard');
    Route::post('/dashboard', 'SubmissionController@getDataDashboard')->name('getDataDashboard');
    Route::post('/dashboard/getDataYear', 'SubmissionController@getDataYear')->name('getDataYear');
    Route::group(['prefix' => 'submission'], function () {
        Route::get('/index', 'SubmissionController@index')->name('index');
        Route::post('/create', 'SubmissionController@createOrUpdate')->name('submission.createOrUpdate');
        Route::post('/updateSubmission/{id}', 'SubmissionController@createOrUpdate')->name('submission.update');
        Route::post('/destroy/{id}', 'SubmissionController@destroy')->name('submission.destroy');
        Route::get('/update/{id}', 'SubmissionController@update')->name('submission.edit');
        Route::get('/exportExcel/{time}', 'SubmissionController@exportExcel')->name('exportExcel');
    });
    Route::group(['prefix' => 'first_model'], function () {
		Route::get('/index', 'FirstModelController@index')->name('first_model');
		Route::post('/create', 'FirstModelController@createOrUpdate')->name('first_model.createOrUpdate');
		Route::post('/update/{id}', 'FirstModelController@createOrUpdate')->name('first_model.update');
		Route::post('/destroy/{id}', 'FirstModelController@destroy')->name('first_model.destroy');
		Route::get('/update/{id}', 'FirstModelController@update')->name('first_model.edit');
	});
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/submission/search','SubmissionController@getSearch');
    Route::post('import','SubmissionController@import')->name('import');
    Route::post('importFirst','FirstModelController@importFirst')->name('importFirst');
});