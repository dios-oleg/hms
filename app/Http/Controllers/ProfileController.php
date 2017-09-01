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
        $user = \Auth::user();

        // Если введен новый пароль, то осуществляется проверка.
        if ( $request->password ) {
            $this->validate($request, [
                'old_password' => 'required|password',
                'password' => 'confirmed|min:8|max:255|alpha_dash|different:old_password',
            ]);

            $user->password = \Hash::make($request->password);
        }

        $user->fill($request->all());
        $user->save();

        return redirect()->route('profile')->with('success', true);
    }
}
