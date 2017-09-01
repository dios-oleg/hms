<?php

namespace App\Http\Controllers;

use App\Models\SystemParameter;
use App\Http\Requests\UpdateSystemParameter;

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
     * @param  App\Http\Requests\UpdateSystemParameter  $systemParameter
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSystemParameter $request, SystemParameter $parameter)
    {
        $parameter->value = $request->value;
        $parameter->save();

        return redirect()->route('settings')->with(['success' => true]);
    }
}
