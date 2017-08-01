<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Http\Requests\Authenticate;
use App\Models\{User, Password_reset};
use Carbon\Carbon;

class AuthController extends Controller{

    public function showLoginForm()
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

    public function resetPasswordForm($token = null)
    {
        return view('auth.passwords.reset', compact('token'));
    }

    public function resetPassword(Request $request)
    {
        // если срок действия токена истек или он отсутствует, то все равно происходит имитация восстановления и предлагает заново отправить сообщение
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|alpha_dash|max:255|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if ( $user ) {
            $password_reset = $user->password_reset()->latest()->first();

            if( $password_reset != null && $password_reset == $request->token && (Carbon::now()->timestamp - Carbon::parse($password_reset->created_at)->timestamp) < (config('auth.passwords.users.expire') * 60) ){

                $user->password = \Hash::make($request->password);
                $user->save();
                $user->password_reset()->delete();

                return redirect()->route('auth.login');
            }
        }

        return view('auth.passwords.timeout');
    }

    public function sendLinkResetPasswordForm() 
    {
        return view('auth.passwords.email');
    }

    public function sendLinkResetPassword(Request $request) 
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email', // или, если адрес не найден, то ничего не делать
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        $token = Str::random(60);
        $password_reset = new \App\Models\Password_reset(['token' => $token]);
        $user->password_reset()->save($password_reset);
        
        $view = 'emails.reset_password';

        //TODO отправить сообщение о восстановлении пароля

        return view('auth.passwords.message');
    }

}
