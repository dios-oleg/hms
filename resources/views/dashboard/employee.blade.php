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
            start: moment().format('YYYY-MM-D'),
            end: moment(new Date(moment().get('year'), 1, 31)).add(1, 'y').format('YYYY-MM-DD') // TODO последний день года или следующий? когда составляется график отпусков?
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
            
            // TODO отправка информации в БД
            var request = $.post("holidays", {data: this.eventData},  function( data ) {
                    console.log(data.email);
                });
            
            console.log('send to db');
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
                //custom_param1: 'something',
                //custom_param2: 'somethingelse'
            },
            error: function() {
                alert('there was an error while fetching events!');
            },
        ]*/
    });


});
@endsection
