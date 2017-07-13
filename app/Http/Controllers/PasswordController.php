<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use app\Models\User;

class PasswordController extends Controller{
    
    public function showResetForm() {
        return view('auth.password.reset');
    }
    
    public function showEmailForm() {
        return view('auth.password.email');
    }
    
    public function reset(Request $request) {
        // TODO задание нового пароля
    }
    
    public function email(Request $request) {
        // TODO отправка сообщения
    }
    
}
