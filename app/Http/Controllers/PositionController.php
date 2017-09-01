<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use App\Http\Requests\PositionRequest;

class PositionController extends Controller
{
    /**
     * Отображение списка всех пользователей.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('positions.index', ['positions' => Position::paginate(10)]);
    }

    /**
     * Отображение формы добавления новой должности.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('positions.create');
    }

    /**
     * Сохранение новой должности.
     *
     * @param  App\Http\Requests\PositionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PositionRequest $request)
    {
        $position = Position::create($request->all());

        return redirect()->route('positions')->with([
          'success' => true,
          'title' => "Должность \"$position->name\" была успешно создана."
        ]);
    }

    /**
     * Отображает страницу редактирования должности.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Position $position)
    {
        return view('positions.edit', compact('position'));
    }

    /**
     * Обновление должности.
     *
     * @param  App\Http\Requests\PositionRequest  $request
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(PositionRequest $request, Position $position)
    {
        $position->update($request->all());

        return redirect()->route('positions.edit', $position)->with(['success' => true]);
    }

    /**
     * Удаление должности.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        if( $position->users->count() != 0) {
            return redirect()->route('positions.edit', $position)->with([
              'error' => true,
              'title' => 'Должность не может быть удалена, т.к. за ней закреплены пользователи.'
            ]);
        }

        $position->delete();

        return redirect()->route('positions')->with([
          'success' => true,
          'title' => "Должность \"$position->name\" (запись №{$position->id}) была успешно удалена."
        ]);
    }
}
