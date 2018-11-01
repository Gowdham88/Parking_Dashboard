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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function(){

//     return View::make('pages.home');
    
// });
Route::get('/', function () {
    return view('forms.login');
});
Route::post('/clogin', 'Auth\CloginController@postlogin');
Route::get('/cameraList', 'CameradetailsController@index');
Route::get('/cameraList/Viewcamera/{cameraID}', 'CameradetailsController@show');
Route::get('/cameraList/Editcamera/{cameraID}', 'CameradetailsController@edit');
Route::get('/cameraList/Addcamera', 'CameradetailsController@create');

// Route::get('cameraList', function()
// {
//     return View::make('pages.cameraList');
// });
Route::get('cameraManagement', function()
{
    return View::make('pages.cameraManagement');
});
Route::get('Reports', function()
{
    return View::make('pages.Reports');
});
// Route::get('contact', function()
// {
//     return View::make('pages.contact');

// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
