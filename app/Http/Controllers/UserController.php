<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enum\Roles;
use Illuminate\Http\Request;
use App\Models\Position;
use Mail;
use App\Http\Requests\UpdateUser;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // TODO проверять в конструкторе
        if ($request->user()->can('is-leader')) {
            
            $sql_where = array();
            $search = array();
            
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
                ->paginate(1); // TODO change to 10
            
            if (request('sort') && request('order'))  {
                $table_sort['order'] = $search['order'] == 'asc' ? 'desc' : 'asc';
                $table_sort['sort'] = request('sort');
            }else{
                $table_sort = null;
            }
            
            $positions = Position::all();
            
            return view('user.index', compact('users', 'search', 'table_sort', 'positions', 'request'));
        }
        
        //abort(403);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $positions = Position::all(); // TODO если ничего нет, то добавление должности или сообщение
        
        return view('user.create', compact('positions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // TODO для первого пользователя только почта, должность
        
        // TODO проверка на дублирующую почту
        $password = '123'; // TODO генерация пароля
        
        $user = User::create([
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'last_name_print' => request('last_name_print'),
            'patronymic' => request('patronymic'),
            'email' => request('email'),
            'address' => request('email'),
            'position_id' => request('position_id'),
            'password' => bcrypt($password),
        ]);
        
        // TODO в очередь и ссылка на восстановление пароля
        Mail::send('emails.created_password', ['password' => $password], function ($m) use ($user) {
            //$m->from('no-reply@hms.by', 'HMS');
            $m->to('dmitrochenkooleg@gmail.com')->subject('Добро пожаловать в HMS!');
            
        });
        
        // TODO если все хорошо, то возврат на страницу пользователей или сообщение о создании пользователя
        return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        if( !$user->id ) $user = \Auth::user();
        
        $positions = Position::all();
        
        $roles = Roles::getConstants();
        
        return view('user.show', compact('user', 'positions', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if( empty($user) ) $user = \Auth::user();
        
        $positions = Position::all();
        
        $roles = Roles::getConstants();
        
        return view('user.edit', compact('user', 'positions', 'roles'));
    }

    /**
     * Update the specified resource in storage.
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
        return redirect('users'); // TODO перенаправление на аккаунт или на просмотр
    }
    
    public function editPasswordForm() {
        return view('user.password');
    }
    
    public function updatePassword(\App\Http\Requests\UpdatePassword $password) {
        // TODO можем вынести в отдельный метод вместе с отправкой пароля
        
        $user = \Auth::user(); // пароль можно изменять только у себя
        
        // TODO сверка пароля с паролем из БД, если совпадает, то можно изменять
        
        $user->password = bcrypt($password->password);
        $user->save();
        
        // TODO save
        
        return redirect()->route('users.account');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // нельзя удалить руководителя если он 1
        // TODO проверку в модель, т.к. для удаления и обновления
        /*$count = User::where('role', Roles::EMPLOYEE)
                     ->where('is_blocked', false)
                     ->count();
        
        if($count > 1 ){
            $user->delete();
            
            return 'delete';
        }
        
        return 'not delete';*/
    }
}
