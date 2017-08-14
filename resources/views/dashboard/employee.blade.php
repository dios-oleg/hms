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
    
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    
    //alert();

    $('#calendar').fullCalendar({
        locale: 'ru',
        businessHours: true,
        validRange: {
            start: moment().add(1, 'd').format('YYYY-MM-D'),
            end: moment(new Date(moment().get('year'), 1, 1)).add(1, 'y').format('YYYY-MM-DD') // TODO последний день года или следующий? когда составляется график отпусков?
            // TODO мб на следующий год можно указывать, когда последние два месяца года?
        },
        selectable: true,
        select: function(start, end){
            var comment = prompt('Вы указали период отпуска с ' + 
                                    moment(start).format('DD.MM.YYYY') + 
                                    ' по ' + moment(end).add(-1, 'd').format('DD.MM.YYYY') + 
                                    '. Вы можете указать комментарий:', 'Трудовой отпуск');
            
            var eventData = {
                title: comment,
                start: start,
                end: end,
                backgroundColor: '#e4b01d',
                textColor: '#332f2f',
                borderColor: '#c6953a'
            };
            
            $('#calendar').fullCalendar('renderEvent', eventData, true);
            
            var request = $.post("holidays", {
                    start_date: moment(start).format('YYYY-MM-DD'),
                    end_date: moment(end).format('YYYY-MM-DD'),
                    comment: comment
                },  
                function( data ) {
                    console.log('Status created is ' + data.status);
                });
        },
        eventDrop: function(event, delta, revertFunc) {
            if (!confirm('Вы действительно желаете изменить период отпуска? Новый период с ' +
                event.start.format('DD.MM.YYYY') + ' по ' +event.end.format('DD.MM.YYYY') + '.')) {
                revertFunc();
            }else{
                // TODO отправка информации в БД
                console.log('send to db');
            }
        },
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,listYear'
        },
        views: {
            listYear: { buttonText: 'список за год' }
        },
        editable: true,
        /*eventSources: [
            url: '/holidays',
            type: 'GET',
            data: {
                // TODO token, email, password, type or page
                //start_date: 'something',
                //end_date: 'somethingelse'
            },
            error: function() {
                alert('there was an error while fetching events!');
            },
        ]*/
    });


});
@endsection
