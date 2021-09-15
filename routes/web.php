<?php
Route::get('/', function () {
    return view('forms.login');
});
Route::post('/clogin', 'Auth\CloginController@postlogin');
Route::get('/cameraList', 'CameradetailsController@index');
Route::get('/cameraManagement', 'CameraImageManagementController@index');
Route::get('/cameraManagement/mask-unmask/{camId}', 'CameraImageManagementController@manageMasking');
Route::get('/cameraManagement/preview', 'CameraImageManagementController@showPreview');
Route::put('/cameraManagement/{id}', 'CameraImageManagementController@updatePoints');
Route::get('/cameraList/add', 'CameradetailsController@create');
Route::get('/cameraList/{cameraID}/edit', 'CameradetailsController@edit');
Route::get('/cameraList/{cameraID}', 'CameradetailsController@show');
Route::put('/cameraList/{id}', 'CameradetailsController@update');
Route::delete('/cameraList/{id}', 'CameradetailsController@destroy');
Route::post('/cameraList', 'CameradetailsController@store');

Route::get('Reports', function()
{
    return View::make('pages.Reports');
});
 
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
