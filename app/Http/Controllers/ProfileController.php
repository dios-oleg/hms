<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfile;

class ProfileController extends Controller
{
    /**
     * Отображает профиль пользователя.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('profile.index', ['user' => \Auth::user()]);
    }

    /**
     * Обновление информации пользователя.
     *
     * @param  \App\Http\Requests\UpdateProfile  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfile $request)
    {
        // TODO забыл сделать обязательное подтверждение для изменения личных данных, нужно ввести пароль

        $user = \Auth::user();

        // Если введен новый пароль, то осуществляется проверка.
        if ( $request->password ) {
            $this->validate($request, [
                'old_password' => 'required|password',
                'password' => 'confirmed|min:8|max:255|different:old_password',
            ]);

            $user->password = \Hash::make($request->password);
            $user->save();
        }

        $user->update($request->all());

        return redirect()->route('profile')->with('success', true);
    }

    public function statistics(){
        // TODO отображение статистики отпусков
    }

}
