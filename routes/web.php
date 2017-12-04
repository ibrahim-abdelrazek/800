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

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
//for Partners
Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', 'HomeController@index')->name('home');
    Route::resource('hotelguest', 'HotelGuestController');
    Route::get('/notifications', 'UserController@notifications');
    Route::get('/threads', 'UserController@threads');
    Route::resource('profile', 'ProfileController');
    Route::resource('settings', 'SettingsController');
    Route::post('settings/update', 'SettingsController@update');
    Route::resource('partnertypes' , 'PartnerTypesController');
    Route::resource('usergroups' , 'UserGroupController');
    Route::resource('users' , 'UserController');
    Route::resource('partners' , 'PartnersController');
    Route::resource('doctors', 'DoctorController');
    Route::get('doctors/viewCard/{id}', 'DoctorController@viewCard');
    Route::get('doctors/get-nurses/{id}', 'DoctorController@getNurses');
    Route::get('users/get-userGroups/{id}', 'UserController@getUserGroups');
    Route::get('doctors/get-patients/{id}', 'DoctorController@getPatients');
    Route::get('doctors/get-doctors/{id}', 'DoctorController@getDoctors');
    Route::get('doctors/get-neighbors/{id}', 'PatientController@getNeighbors');
    Route::resource('patients', 'PatientController');
    Route::resource('nurses', 'NurseController');
    Route::get('nurse/viewCard/{id}', 'NurseController@viewCard');
    Route::resource('products', 'ProductController');
    Route::get('orders/print/{id}', 'OrderController@download');
    Route::resource('orders', 'OrderController');
    Route::get('patient/searchpatient', 'PatientController@searchpatient');
    Route::post('orders/update-status', 'OrderController@updateStatus');
    Route::resource('status', 'StatusController');
    Route::group(['prefix' => 'messages'], function () {
        Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index']);
        Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
        Route::post('/', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
        Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
        Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
    });
    Route::get('/get-user-group/{id}', 'UserController@getUserGroups')->name("get-user-group");
    Route::get('/getall/{id}', 'OrderController@getAll')->name("getall");
});

