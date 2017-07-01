<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Position;
use App\Enum\Roles;

class AppController extends Controller
{
    public function index(Request $request) {
        if (Auth::check())  {
            // Для каждой роли свой dashboard
            return view('dashboard.'.Auth()->user()->role);
            
            
            // Для руководителя отдельный dashboard
            /*if(Auth()->user()->can('is-leader')) {
                return view('dashboard.leader');
            }
            
            return view('dashboard.employee');
            */
        }
        elseif (User::isUndefinedLeader()) {
            // TODO не должно быть в заголовке логин и регистрации
            
            $positions = Position::all();
            
            return view('auth.first', compact('positions'));
        }
        
        return redirect('login');
    }
    
    public function first(Request $request) {
        // TODO если был передан id, то не добавление, а запись ID
        $position = Position::create([
            'name' => $request->input('position'),
            'name_print' => $request->input('position_print'),
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
    
        $first_user->role = Roles::LEADER;
        
        // перенаправление на страницу или отображение об успешном добавлении
    }
}
