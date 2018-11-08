<?php
Route::get('/', function () {
    return view('forms.login');
});
Route::post('/clogin', 'Auth\CloginController@postlogin');
Route::get('/cameraList', 'CameradetailsController@index');
Route::get('/cameraManagement', 'CameraImageManagementController@index');
Route::get('/cameraManagement/mask-unmask/{camId}', 'CameraImageManagementController@manageMasking');
Route::get('/cameraList/Viewcamera/{cameraID}', 'CameradetailsController@show');
Route::get('/cameraList/Editcamera/{cameraID}', 'CameradetailsController@edit');
Route::get('/cameraList/Addcamera', 'CameradetailsController@create');

Route::get('Reports', function()
{
    return View::make('pages.Reports');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
