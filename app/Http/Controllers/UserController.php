<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use App\Position;
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

        if ($request->user()->can('is-head')) {
            $users = User::paginate(2); // TODO change to 10
            $search['email'] = request('email');
            $search['position'] = request('position');
            $search['sort'] = request('sort');
            $search['order'] = request('order');
            $positions = Position::all();
            
            return view('user.index', compact('users', 'search', 'positions'));
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
        $positions = Position::orderBy('priority', 'desc')->get(); // TODO если ничего нет, то добавление должности или сообщение
        
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
        
        // TODO в очередь
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
