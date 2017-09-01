<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\SendToken;
use App\Services\PasswordToken;
use App\Http\Requests\ResetPassword;
use App\Http\Requests\SendLinkPasswordToken;

class ResetPasswordController extends Controller
{

    /**
     * Отобразит форму для ввода email.
     *
     * @return \Illuminate\Http\Response
     */
    public function emailForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Отправит ссылку c токеном для восстановления пароля.
     *
     * @param  \App\Http\Requests\SendLinkPasswordToken  $request
     * @return \Illuminate\Http\Response
     */
    public function sendLink(SendLinkPasswordToken $request)
    {
        $user = User::where('email', $request->email)->first();
        PasswordToken::create($user);
        \Mail::to($user->email)->queue(new SendToken($user->password_reset->token, 'emails.reset_password', 'Восстановление пароля!'));

        return view('auth.passwords.message');
    }

    /**
     * Отображает форму для ввода нового пароля при действительном токене.
     *
     * @param  String  $token
     * @return \Illuminate\Http\Response
     */
    public function newPasswordForm($token)
    {
        return PasswordToken::isValid($token) ? view('auth.passwords.reset', compact('token')) : view('auth.passwords.timeout');
    }

    /**
     * Сбрасывает пароль при действительном токене.
     *
     * @param  \App\Http\Requests\ResetPassword  $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function reset(ResetPassword $request)
    {
        $user = PasswordToken::getUserByToken($request->token);
        $user->password = \Hash::make($request->password);
        $user->save();
        $user->password_reset()->delete();

        return redirect()->route('auth.login');
    }
}
