<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function login(Request $request) {
        $request->validate([
            'username' => ['required'],
            'passwd' => ['required'],
        ]);

        $username = $request->username;
        $password = $request->passwd;
        // Check if users are empty
        $hasUser = User::first();
        if(!$hasUser){

            // Register
            $onlyUser = new User;
            $onlyUser->username = $username;
            $onlyUser->password = $password;
            $onlyUser->save();
        }

        // Login
        Auth::attempt(['username' => $username, 'password' => $password], true);
        return redirect()->intended('dashboard');
    }
}
