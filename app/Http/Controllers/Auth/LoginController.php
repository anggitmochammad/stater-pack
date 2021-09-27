<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function index()
    {
        return view('pages.auth.login');
    }
    public function post(Request $request)
	{
		$credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials) && Auth::user()->role == 1) {
            return redirect()->route('admin');
        }else if(Auth::attempt($credentials) && Auth::user()->role == 2) {
            return redirect()->route('user');
        }else{
            return redirect()->route('login');
        }
	}
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

    	return response()->json([
    		'success'    => true
    	], 200);
    }
}
