<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfile;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();

        //dd($user);

        return view('profile.index', compact('user'));

    }

    /**
     * Обновление информации пользователя.
     *
     * @param  \app\Http\Requests\UpdateProfile  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfile $request)
    {
        $user = \Auth::user();

        // Если введен новый пароль, то осуществляется проверка.
        if ( $request->password ) {
            $this->validate($request, [
                'old_password' => 'required|password',
                'password' => 'required_unless:old_password,|confirmed|min:8|max:255|different:old_password',
            ]);

            $user->password = \Hash::make($request->password);
            $user->save();
        }

        $user->update($request->all());

        return redirect()->route('profile')->with('is_changed', true);
    }

    public function statistics(){
        // TODO отображение статистики отпусков
    }

}
