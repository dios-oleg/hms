<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Position;

class AppController extends Controller
{
    public function index() {
        if (Auth::check())  {
            if(Auth::user()->head) {
                return ('dashbord-boss'); // TODO один путь, но разные страницы
                //return view('dashbord.head);
            }
            
            return ('dashbord-user'); // TODO один путь но разные страницы
            //return view('dashbord.user);
        }
        elseif (User::where('head', 1)->count() == 0) {
            // TODO не должно быть в заголовке логин и регистрации
            
            //передать существующие должности если они есть
            
            return view('auth.first');
        }
        
        return redirect('login');
    }
    
    public function first(Request $request) {
        // еще раз проверка и только потом добавление
        $position = Position::create([
            'name' => $request->input('position'),
            'name_print' => $request->input('position_print'),
            'priority' => 1000,
        ]);
        
        
        $first_user = User::create([
           'first_name' => $request->input('first_name'),
           'last_name' => $request->input('last_name'),
           'last_name_print' => $request->input('last_name_print'),
           'patronymic' => $request->input('patronymic'),
           'email' => $request->input('email'),
           'address' => $request->input('address'),
           'position_id' => $position->id,
           'password' => bcrypt($request->input('password')),
        ]);
    
        $first_user->setHead();
        
        // перенаправление на страницу или отображение об успешном добавлении
    }
}
