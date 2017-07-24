<?php

namespace App\Http\Controllers;

use App\Models\SystemParameter;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parameters = SystemParameter::all();

        return view('settings.index', compact('parameters'));
    }

    public function edit(SystemParameter $parameter)
    {
        return view('settings.edit', compact('parameter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SystemParameter  $systemParameter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SystemParameter $parameter)
    {
        // TODO по сути еще тип данных нужно проверять в зависимости от типа значения, но тогда в БД нужно прописать
        $this->validate($request, [
            'value' => 'required'
        ]);

        $parameter->value = $request->value;
        $parameter->save();

        // TODO сообщение об успешном изменении, возврат на страницу параметров системы

        return redirect('settings');
    }

}
