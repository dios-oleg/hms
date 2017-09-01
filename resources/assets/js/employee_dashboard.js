$(document).ready(function() {

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    //alert(moment().add(1, 'd').format('YYYY-MM-DD'));

    $('#calendar').fullCalendar({
        locale: 'ru',
        //businessHours: true, // TODO изменить цвет, а то сливается с неактивными днями
        validRange: {
            start: moment().add(1, 'd').format('YYYY-MM-DD'),
            end: moment(new Date(moment().get('year'), 2, 1)).add(1, 'y').format('YYYY-MM-DD')
        },
        selectable: true,
        select: function(start, end) {
            var comment = prompt('Вы указали период отпуска с ' +
                                    moment(start).format('DD.MM.YYYY') +
                                    ' по ' + moment(end).add(-1, 'd').format('DD.MM.YYYY') +
                                    '. Вы можете указать комментарий:', 'Трудовой отпуск');

            var eventData = {
                id: 1, // присвоить уникальный/рандомный номер
                title: (comment.trim().length == 0) ? 'Новый отпуск' : comment,
                start: start,
                end: end,
                backgroundColor: '#e4b01d',
                textColor: '#332f2f',
                borderColor: '#c6953a' // TODO to class
                //className:
                //editable: false, // если не ожидание
                //id: //
                //url: // to print or edit
            };

            $('#calendar').fullCalendar('renderEvent', eventData, true);

            var request = $.post("holidays", {
                    start_date: moment(start).format('YYYY-MM-DD'),
                    end_date: moment(end).format('YYYY-MM-DD'),
                    comment: comment,
                    timeId: eventData.id
                },
                function( data ) {
                    console.log('Status created is ' + data.status); // TODO а надо ли? мб сообщение об ошибке добавить, но выполняется только проверка дат
                    // хотя можно сделать на пересечение отпусков у одного пользователя
                    // from eventDate.id
                    var createdEvent = $('#calendar').fullCalendar('clientEvents', 1);
                    createdEvent[0].title = 'Новый отпуск'; // change id from DB
                    $('#calendar').fullCalendar('updateEvent', createdEvent[0]);

                });
        },
        eventDrop: function(event, delta, revertFunc) {
            //нельзя перемещать подтвержденные заявки и туда же нельзя добавить отпуск, т.е. будет помечена фоном и overlap: false
            // view-source:https://fullcalendar.io/js/fullcalendar-3.4.0/demos/background-events.html
            // ограничение перемещения в диапазоне дат, привязка к id
            if (!confirm('Вы действительно желаете изменить период отпуска? Новый период с ' +
                event.start.format('DD.MM.YYYY') + ' по ' +event.end.format('DD.MM.YYYY') + '.')) {
                revertFunc();
            }else{
                // TODO отправка информации в БД. нужно инициализировать запись, как вариант по датам, найти по датам и комментарию. Перемещать подтвержденные нельзя
                console.log('send to db');
            }
        },
        /*eventClick: function(event) {
    				// opens events in a popup window
    				window.open(event.url, 'gcalevent', 'width=700,height=600');
    				return false;
  			},*/
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
