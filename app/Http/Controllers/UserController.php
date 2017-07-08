<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Position;
use Mail;

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
        if( isset($user) ) $user = $request->user();
        
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if( isset($user) ) $user = Auth::user();
        
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
        //только изменение информации, кроме head и blocked
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
        $count = User::where('head', true)
                     ->where('blocked', false)
                     ->count();
        
        if($count > 1 ){
            $user->delete();
            
            return 'delete';
        }
        
        return 'not delete';
    }
}
