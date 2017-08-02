<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Password_reset};
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Jobs\SendResetPassword;

class PasswordController extends Controller{

    /**
     * Отображает форму для ввода логина, с последующим восстановлением пароля
     *
     * @param  String  $token
     * @return \Illuminate\Http\Response
     */
    public function resetPasswordForm($token = null)
    {
        return view('auth.passwords.reset', compact('token'));
    }

    /**
     * Сбрасывает пароль при действительном токене и логине.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

            if( $password_reset != null && $password_reset->token == $request->token && (Carbon::now()->timestamp - Carbon::parse($password_reset->created_at)->timestamp) < (config('auth.passwords.users.expire') * 60) ) {
                $user->password = \Hash::make($request->password);
                $user->save();
                $user->password_reset()->delete();

                return redirect()->route('auth.login');
            }
        }

        return view('auth.passwords.timeout');
    }

    /**
     * Отобразит форму для ввода почты/логина для отправки письма на почту
     *
     * @return \Illuminate\Http\Response
     */
    public function sendLinkResetPasswordForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Отправит ссылку для восстановления пароля.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendLinkResetPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email', // или, если адрес не найден, то ничего не делать
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        $this->sendMail($user);

        return view('auth.passwords.message');
    }

    /**
     * Отправит ссылку для задания пароля.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function sendLinkCreatePassword(User $user)
    {
        $this->sendMail($user);

        return redirect()->route('users.edit', $user->id)->with(['success' => true, 'reset_password' => true]);
    }

    /**
     * Отправит сообщение на почту пользователя с указанным представлением
     * или представлением по умолчанию (восстановление пароля).
     *
     * @param  \App\User  $user
     * @param  String  $view
     * @param  String  $subject
     * @return void
     */
    static public function sendMail($user, $view = 'emails.reset_password', $subject = null){
        $token = Str::random(60);
        $password_reset = new \App\Models\Password_reset(['token' => $token]);
        $user->password_reset()->save($password_reset);

        dispatch(new SendResetPassword($user, $token, $view, $subject));
    }
}
