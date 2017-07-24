<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enum\Roles;
use Illuminate\Http\Request;
use App\Models\Position;
use Mail;
use App\Http\Requests\{UpdateUser, StoreUser};

class UserController extends Controller
{
    /**
     * Отобразит список пользователей.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // TODO проверять в конструкторе или достаточно в маршрутах, здесь нет доступа для обычного пользователя

            $sql_where = array();
            $search = array();

            // Request::only('username', 'password'); except

            if (request('email'))  {
                $search['email'] = request('email');
                $sql_where[] = array('email', 'like', '%'.$search['email'].'%');
            }

            if (request('position') && request('position') != 0)  {
                $search['position'] = request('position');

                // TODO несколько должностей
                $sql_where[] = array('position_id', $search['position']);
            }

            if(request('sort') && request('order')){
                $search['sort'] = request('sort');
                $search['order'] = (request('order') == 'asc' || request('order') == 'desc') ? request('order') : 'asc';

                switch (request('sort')) {
                    case 'email';
                        $sql_order = array('column' => $search['sort'], 'order' => $search['order']);
                    break;
                    case 'name';
                        $sql_order = array('column' => 'last_name', 'order' => $search['order']);
                    break;

                    default :
                        $sql_order = array('column' => 'email', 'order' => 'asc');

                    break;
                }

            }else{
                $sql_order = array('column' => 'email', 'order' => 'asc');
            }

            $users = User::where($sql_where)
                ->orderBy($sql_order['column'], $sql_order['order'])
                ->paginate(10);

            if (request('sort') && request('order'))  {
                $table_sort['order'] = $search['order'] == 'asc' ? 'desc' : 'asc';
                $table_sort['sort'] = request('sort');
            }else{
                $table_sort = null;
            }

            $positions = Position::all();

            return view('user.index', compact('users', 'search', 'table_sort', 'positions', 'request'));

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
            'email' => request('email'),
            'address' => ' ',
            'position_id' => request('position'),
            'password' => bin2hex(random_bytes(25)),
        ]);

        // TODO в очередь и ссылка на восстановление пароля
        /*Mail::send('emails.created_password', ['password' => $password], function ($m) use ($user) {
            //$m->from('no-reply@hms.by', 'HMS');
            $m->to('dmitrochenkooleg@gmail.com')->subject('Добро пожаловать в HMS!');

        });*/

        // TODO если все хорошо, то возврат на страницу пользователей или сообщение о создании пользователя
        // $user_created = true;
        return redirect()->route('users'); // ->withInput($request->except('email'))
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
     // TODO удалить
    public function show(Request $request, User $user)
    {
        if( ! $user->id ) $user = \Auth::user();
        
        $positions = Position::all();

        $roles = Roles::getConstants();

        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    // TODO Отображение и редактирование на одной странице
    public function edit(User $user)
    {
        if( ! $user->id ) $user = \Auth::user();

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
        // TODO нужно своя проверка на соответствие ролей и должностей, чтобы была из заданного критерия

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->last_name_print = $request->last_name_print;
        $user->patronymic = $request->patronymic;
        $user->address = $request->address;

        if (\Auth::user() == $user){

            // TODO validation + мб в отдельный метод изменение пароля?
            if ($request->old_password != null)  {
                // проверка на корректность, а также правила ввода нового пароля
                //$user->password = $request->password;
            }

        }

        // TODO Только для админа и со страницы users
        if (\Auth::user()->can('is-leader')){
            $user->position_id = $request->positions; // TODO нужно ли делать проверку на существование?

            $blocked = $request->blocked == true;

            if( !User::isNotLastLeader() && ($blocked || $request->roles != Roles::LEADER) && $user->id == \Auth::user()->id ){
                return 'error';
            }else{
                $user->role = $request->roles;
                $user->is_blocked = $blocked;
                $user->comment = $user->is_blocked ? $request->comment : NULL;
            }

        }

        $user->save();

        // TODO если редактирование аккаунта, то один маршрут, если как пользователя, то другой
        if ( \Route::currentRouteName() == 'users.account.update' ){
            return redirect()->route('users.account');
        }

        return redirect()->route('users.show', $user->id);
    }

}
