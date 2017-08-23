<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Authenticate;

class AuthController extends Controller{

    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Authenticate $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_blocked' => false], $request->remember))  {
            return redirect()->intended('/');
        }

        return redirect()->route('auth.login')->withInput()->with(['error' => true]);
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
}
