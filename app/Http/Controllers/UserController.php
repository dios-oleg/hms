<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Position;
use App\Enum\Roles;
use Illuminate\Http\Request;
use App\Http\Requests\{UpdateUser, StoreUser};
use App\Mail\SendToken;
use App\Services\PasswordToken;
use App\Services\SystemStatutes;

class UserController extends Controller
{
    /**
     * Отобразит список пользователей.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $parameters = $request->only('email', 'position' /*, 'sort', 'order'*/);
        $parameters['sort'] = $request->input('sort', 'email');
        $parameters['order'] = $request->input('order', 'asc');

        $query = User::query();
        $query->where('email', 'like', '%'.$parameters['email'].'%');

        if ( $parameters['position'] && $parameters['position'] != 0 ) {
            $query->where('position_id', $parameters['position']);
        }

        $field = array_get($parameters, 'sort'); // не задает значение по умолчанию
        $order = array_get($parameters, 'order');
        $query->orderBy($field, $order);

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
        $positions = Position::all();
        $roles = Roles::getConstants();

        return view('user.create', compact('positions', 'roles'));
    }

    /**
     * Сохранит нового пользователя в БД.
     *
     * @param  \App\Http\Requests\StoreUser  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
        $user = new User();
        $user->email = $request->email;
        $user->position_id = $request->position;
        $user->save();

        PasswordToken::create($user);
        \Mail::to($user->email)->queue(new SendToken($user->password_reset->token, 'emails.specify_password', 'Добро пожаловать в систему!'));

        return redirect()->route('users')->with(['success' => true]);
    }

    /**
     * Отображение страницы для редактирования информации пользователя.
     *
     * @param  \App\Models\User  $user
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
     * @param  \App\Http\Requests\UpdateUser  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, User $user)
    {
        if (SystemStatutes::canChangeRole($user->id, $request->role, $request->blocked)) {
            return redirect()->route('users.edit', $user->id)->with(['error' => true]);
        } else {
            $user->role = $request->role;
            $user->is_blocked = (bool) $request->blocked;
            $user->comment = $request->blocked ? $request->comment : NULL;
        }

        $user->position_id = $request->position;
        $user->fill($request->only('first_name', 'last_name', 'last_name_print', 'patronymic', 'address'));
        $user->save();

        return redirect()->route('users.edit', $user->id)->with(['success' => true]);
    }
}
