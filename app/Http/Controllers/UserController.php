<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Position;
use App\Enum\Roles;
use Illuminate\Http\Request;
use App\Http\Requests\{UpdateUser, StoreUser};
use App\Http\Controllers\PasswordController;

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
        $positions = Position::all();
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
        $user = new User([
            'first_name' => ' ',
            'last_name' => ' ',
            'last_name_print' => ' ',
            'patronymic' => ' ',
            'address' => ' ',
        ]);

        $user->email = $request->email;
        $user->position_id = $request->position;
        $user->password = bin2hex(random_bytes(25));
        $user->save();

        PasswordController::sendMail($user, 'emails.specify_password');

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
        //if( !User::isNotLastLeader() && ($request->blocked || $request->role != Roles::LEADER) && $user->id == \Auth::user()->id ){ // нельзя оставить систему без администратора
        if( ($request->blocked || $request->role != Roles::LEADER) && $user->id == \Auth::user()->id ){ // пользователь не может сам себя заблокировать или изменить роль
            return redirect()->route('users.edit', $user->id)->with(['error' => true]);
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
}
