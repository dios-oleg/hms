<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enum\Roles;
use Illuminate\Http\Request;
use App\Models\Position;
use Mail;
use Illuminate\Support\Str;
use App\Http\Requests\{UpdateUser, StoreUser};
use App\Jobs\SendResetPassword;

class UserController extends Controller
{
    /**
     * Отобразит список пользователей.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $parameters = $request->only('email', 'position', 'sort', 'order');

        $query = User::Query();
        $query->where('email', 'like', '%'.$parameters['email'].'%');

        if ( $parameters['position'] && $parameters['position'] != 0 ) {
            $query->where('position_id', $parameters['position']);
        }

        if ($parameters['sort'] && $parameters['order']) {
            $query->orderBy($parameters['sort'] == 'email' ? 'email' : 'last_name', $parameters['order'] == 'asc' ? 'asc' : 'desc' );
        }

        $users = $query->paginate(10);

        $positions = Position::all();

        return view('user.index', compact('users', 'parameters', 'positions', 'request'));
    }

    /**
     * Отобразит форму добавления нового пользователя.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $positions = Position::all(); // TODO если ничего нет, то добавление должности или сообщение || база не дб пуста
        $roles = Roles::getConstants();

        return view('user.create', compact('positions', 'roles'));
    }

    /**
     * Сохранит нового пользователя в БД.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
        // Пользователь сам должен заполнить пустые поля
        $user = User::create([
            'first_name' => ' ',
            'last_name' => ' ',
            'last_name_print' => ' ',
            'patronymic' => ' ',
            'email' => $request->email,
            'address' => ' ',
            'position_id' => $request->position,
            'password' => bin2hex(random_bytes(25)),
        ]);

        // TODO в очередь и ссылка на восстановление пароля
        /*Mail::send('emails.created_password', ['password' => $password], function ($m) use ($user) {
            //$m->from('no-reply@hms.by', 'HMS');
            $m->to('dmitrochenkooleg@gmail.com')->subject('Добро пожаловать в HMS!');

        });*/

        return redirect()->route('users')->with(['success' => true]);
    }

    /**
     * Отображение страницы для редактирования информации пользователя.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $positions = Position::all();
        $roles = Roles::getConstants();

        return view('user.edit', compact('user', 'positions', 'roles'));
    }

    /**
     * Обновит информацию пользователя.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, User $user)
    {
        if( !User::isNotLastLeader() && ($blocked || $request->role != Roles::LEADER) && $user->id == \Auth::user()->id ){
            return 'error'; // добавить отдельную проверку и вызвать исключение // или не может заблокировать сам себя, но при этом в провайдера добавить проверку на блокировку
        }else{
            $user->role = $request->role;
            $user->is_blocked = (bool) $request->blocked;
            $user->comment = $request->blocked ? $request->comment : NULL;
        }

        $user->position_id = $request->position;
        $user->save();
        $user->update($request->only('first_name', 'last_name', 'last_name_print', 'patronymic', 'address'));

        return redirect()->route('users.edit', $user->id)->with(['success' => true]);
    }
    
    /**
     * Отправит ссылнку для восстановления (задания нового) пароля.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(User $user) {
        $token = Str::random(60);
        $password_reset = new \App\Models\Password_reset(['token' => $token]);
        $user->password_reset()->save($password_reset);

        $this->dispatch(new SendResetPassword($user, $token)); 

        return redirect()->route('users.edit', $user->id)->with(['success' => true, 'reset_password' => true]);
    }

}
