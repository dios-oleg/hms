<?php

namespace App\Http\Controllers;

use App\Models\SystemParameter;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    /**
     * Отображает список всех свойств Системы и их значения.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('settings.index', ['parameters' => SystemParameter::all()]);
    }

    public function edit(SystemParameter $parameter)
    {
        return view('settings.edit', compact('parameter'));
    }

    /**
     * Обновляет значение свойства Системы.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SystemParameter  $systemParameter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SystemParameter $parameter)
    {
        $this->validate($request, [
            'value' => 'required'
        ]);

        $parameter->value = $request->value;
        $parameter->save();

        return redirect()->route('settings')->with(['is_changed' => true]);
    }

}
