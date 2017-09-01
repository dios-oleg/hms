<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function index(Request $request) {
        if (Auth::check()) {
            // Для каждой роли свой dashboard.
            return view('dashboard.'.Auth()->user()->role);

            /*
            // Для руководителя отдельный dashboard.
            return (Auth()->user()->can('is-leader')) ? view('dashboard.leader') : view('dashboard.employee');
            */
        }

        return redirect()->route('auth.login.form');
    }
}
