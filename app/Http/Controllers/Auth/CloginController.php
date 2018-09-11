<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class CloginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

     public function postLogin(Request $request)
    {
        
        if ($request->email == '321@gmail.com' && $request->password == '321') {
            // $user = User::find($request->email); // you must have record in your user table to trigger the login.
            // Auth::login($user);
            // return redirect('processmaker');
            // dd($request->all());
            return view('pages.cameralist');     
        }
        else {
        	return sprintf("Enter correct Username and password");
        }
        
    }
}
