<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = \Auth::user();
        
        $this->validate($request, [
            'first_name' => 'required|min:2|max:255',
            'last_name' => 'required|min:2|max:255',
            'last_name_print' => 'required|min:2|max:255',
            'patronymic' => 'required|max:255',
            'address' => 'required|min:2|max:255',
        ]);
        
        // Если введен новый пароль, то осуществляется проверка.
        if ( $request->password ) {
            $this->validate($request, [
                'old_password' => 'required', // TODO соответствовать значению из БД // TODO свое правило
                'password' => 'required_unless:old_password,|confirmed|min:8|max:255|different:old_password',
            ]);
            
            $user->password = bcrypt($request->password);
            $user->save();
        }
        
        $user->update($request->all());
        
        // TODO Обновление информации пользователя, в т.ч. пароль
    }

    public function statistics(){
        // TODO отображение статистики отпусков
    }

}
