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
            return redirect()->intended('/');
            //return redirect()->intended('/');
        }
        
        return 'bad password'; // TODO неверный логин или пароль
    }
    
    public function logout() {
        Auth::logout();
        
        return redirect('/');
    }
    
    public function showRegistrationForm() {
        return view('auth.register'); // TODO добавить сюда регистрацию первого пользователя/админа - доступно будет только один раз
        // TODO убрать метод first из AppController
    }
    
    public function registration() {
        // TODO добавление нового пользователя и валидация
    }
    
}
