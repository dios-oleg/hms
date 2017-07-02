<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use app\Models\User;

class AuthController extends Controller{
    
    public function showLoginForm() {
        return view('auth.login');
    }
    
    public function authenticate(Request $request) {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember))  {
            return 'ok';
            //return redirect()->intended('/');
        }
        
        return 'h'; // TODO неверный логин или пароль
    }
    
    public function logout() {
        Auth::logout();
        
        return redirect('/');
    }
    
    public function showRegistrationForm() {
        // TODO view('auth.register');
    }
    
    public function registration() {
        // TODO добавление нового пользователя и валидация
    }
    
}
