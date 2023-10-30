<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    function login(Request $request) {
        // Auth
        // dd($request->all());

        // Redirect to Home
        return redirect()->route('dashboard');
    }
}
