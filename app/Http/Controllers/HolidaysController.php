<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\HolidaysRequest;

class HolidaysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // TODO отображение всех заявок или определение вызова методов
        if (empty($user)) {
            $holidays = Holiday::all();
        } else {
            //$holidays =
        }

        return $holidays;

        // TODO получить либо все отпуска, либо конкретного пользователя
        // TODO все можно получить, только если админ
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('holidays.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HolidaysRequest $request)
    {
        // TODO проверка значений и сохранение или предупреждение, если за год превышает количество дней отпуска. Но сохранить можно
        $user = \Auth::user();
        $user->holidays()->create($request->only('start_date', 'end_date', 'comment'));

        return $request->ajax() ? \Response::json(['status' => true]) : redirect()->route('holidays');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function show(Holiday $holiday)
    {
        // TODO Отображение заявки на отпуск и печать заявки

        return ('holidays.show');
    }

    public function toPrint(Holiday $holiday){
        // TODO формирование страницы на печать
        // \App\Models\SystemParameter
        return ('holidays.blank');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function edit(Holiday $holiday)
    {
        // TODO редактирование заявки, доступно если она не принята
        // редактировать может только владелец
        return view('holidays.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Holiday $holiday)
    {
        // обновлять можно, когда она не принята
        // редактировать может только владелец
    }

    public function updateStatus(Request $request, Holiday $holiday){
        // TODO обработка сохранения статуса
        // Может изменять только руководитель
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function destroy(Holiday $holiday)
    {
        // удалять можно, когда у нее нет статусов
        // редактировать может только владелец
    }
}
