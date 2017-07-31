@extends('layouts.app')

@section('title', 'HMS')

@section('content')
Основной интерфейс системы. В нём пользователь должен иметь возможность просматривать, добавлять, редактировать и удалять заявки на отпуск.
табличный - список заявок:
дата подачи заявки;
интервал заявки (дата начала и дата окончания отпуска);
статус.
<div id="calendar"></div>
@endsection

@section('scripts')
$(document).ready(function() {

    $('#calendar').fullCalendar({
        locale: 'ru',
        businessHours: true,
        validRange: {
            start: '2017-07-15', // TODO текущая дата
            end: '2017-12-31' // TODO последний день года или следующий? когда составляется график отпусков?
        },
        selectable: true,
        select: function(start, end){
            // TODO задание отпуска и комментария
            alert(start.date()+' '+end.date())
        },
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,listWeek,listMonth,listYear'
        },
        buttonText: {
            today: 'сегодня',
        },
        views: {
            month: { buttonText: 'календарь' },
            listWeek: { buttonText: 'список за неделю' },
            listMonth: { buttonText: 'список за месяц' },
            listYear: { buttonText: 'список за год' }
        },
        editable: true,
        events: [
            {
                title: 'All Day Event',
                start: '2017-07-01'
            },
            {
                title: 'Long Event',
                start: '2017-07-07',
                end: '2017-07-10'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: '2017-07-09'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: '2017-07-16'
            },
            {
                title: 'Conference',
                start: '2017-07-11',
                end: '2017-07-13'
            },
            {
                title: 'Meeting',
                start: '2017-07-12',
                end: '2017-07-12'
            },
            {
                title: 'Lunch',
                start: '2017-07-12'
            },
            {
                title: 'Meeting',
                start: '2017-07-12'
            },
            {
                title: 'Happy Hour',
                start: '2017-07-12'
            },
            {
                title: 'Dinner',
                start: '2017-07-12'
            },
            {
                title: 'Birthday Party',
                start: '2017-07-13'
            }
        ],

    });


});
@endsection
