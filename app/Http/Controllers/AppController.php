<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function index(Request $request) {
        if (Auth::check())  {
            // Для каждой роли свой dashboard
            return view('dashboard.'.Auth()->user()->role, ['token' => Auth::user()->password_reset->valid_token]);

            // Для руководителя отдельный dashboard
            /*if(Auth()->user()->can('is-leader')) {
                return view('dashboard.leader');
            }

            return view('dashboard.employee');
            */
        }

        return redirect()->route('auth.login.form');
    }
}
