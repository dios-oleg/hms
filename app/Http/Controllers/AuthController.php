<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Mail;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller{
    
    public function showLoginForm() {
        return view('auth.login');
    }
    
    public function authenticate(Request $request) {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember))  {
            return redirect()->intended('/');
            //return redirect()->intended('/');
        }
        
        // TODO неверный логин или пароль
        return 'bad password'; 
    }
    
    public function logout() {
        Auth::logout();
        
        return redirect('/');
    }
    
    public function showRegistrationForm() {
        // TODO добавить сюда регистрацию первого пользователя/админа - доступно будет только один раз
        return view('auth.register'); 
        // TODO убрать метод first из AppController
    }
    
    public function registration() {
        // TODO добавление нового пользователя и валидация
    }
    
    public function resetPasswordForm(Request $request, $token = null) {
        // форма для ввода нового пароля и почты
        
        // TODO получает адрес и токен с ссылки и заполняет страницу
        
        // TODO если токен истек, то не действительно восстановление
        
        return view('auth.passwords.reset', compact('token'));
    }
    
    public function resetPassword(Request $request) {
        // ПРОВЕРКА ТОКЕНА если токен устарел по БД, то сразу ошибка. Или если не найден в БД
        echo $request->token;
        echo $request->email;
        echo $request->password;
        $user = User::where('email', $request->email)->first();
        
        $password_reset = $user->password_reset()->where('token', $request->token)->first();
        
        //echo  \Carbon::now();
        if( (Carbon::now()->timestamp - Carbon::parse($password_reset->created_at)->timestamp) < (config('auth.passwords.users.expire') * 60) ){
            echo "es";
            // TODO восстановить пароль
            // удалить все записи с токенами с данным пользователем
        }else{
            echo "fA";
            // TODO Ошибка о восстановлении пароля, время истекло, ссылка недействительна
        }
        
        //echo $password_reset;
        // TODO проверка времени восстановления $password_reset->created_at; до текущего момента
        // TODO время жизни пароля взять из настроек приложения config('auth.passwords.users.expire')
       //$user->password_reset
        // TODO валидация
        
        // TODO замена пароля и либо авторизация либо переадресация на страницу входа
        
        // TODO удаление из БД записей пользователя с токенами для восстановлении пароля
        // проверка токена, почты и пароля
        return 'reset password';
    }
    
    public function sendLinkResetPasswordForm() {
        // форма для ввода почты для восстановления пароля
        return view('auth.passwords.email');
    }
    
    public function sendLinkResetPassword(Request $request) {
        // TODO ДАнный метод использовать для восстановления забытого пароля и для задания пароля Новым пользователям
        // TODO отправка ссылки для восстановления пароля
        // TODO validate Email
        
        // TODO check email 
        $user = \App\Models\User::find(1);
        
        $token = Str::random(60);
        
        $password_reset = new \App\Models\Password_reset(['token' => $token, 'user_id' => $user->id]);
        
        $user->password_reset()->save($password_reset);
        
        
        // TODO добавить в БД с привязкой к почте и времени
        
        if(true){
            Mail::send('emails.created_password', ['user' => $user, 'token' => $token], function ($m) use ($user){
                $m->from('fff@ff.by', 'YA');
                
                //$m->to($user->email, $user->name)->subject('Восстановление пароля!');
                $m->to('dmitrochenkooleg@gmail.com', $user->name)->subject('Восстановление пароля!');
            });
        }
        
        // TODO Ссылка была отправлена на почту, проверьте свою почту и перейдите по полученной ссылке для восст пароля
        // или ошибка, адрес не найден
        
        
        return 'send email';
    }
    
}
