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
        $this->validate($request, [
            'value' => 'required'
        ]);

        $parameter->value = $request->value;
        $parameter->save();

        return redirect()->route('settings')->with(['is_changed' => true]);
    }

}
