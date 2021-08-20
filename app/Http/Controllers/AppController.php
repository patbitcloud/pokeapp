<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{

    public function landing()
    {
        return redirect()->route('login');
    }

    public function index()
    {
        $authUser = auth()->user();

        return view('dashboard', compact('authUser'));
    }
}
