@extends('layouts.app')

@section('title', 'Создание заявки')

@section('content')
<form method="POST" action="{{ route('holidays.store') }}" class="form-horizontal">
    {{ csrf_field() }}

    <div class="form-group">
        <div class="control-label col-sm-3">
            <label for="start_date">Дата начала отпуска</label>
        </div>
        <!--div class='input-group date' id=''>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
        </div-->
        <div class="col-sm-9">
            <input type="text" class="form-control" id="start_date" name="start_date" value="" required>
        </div>
    </div>
    <div class="form-group">
        <div class="control-label col-sm-3">
            <label for="end_date">Дата окончания отпуска</label>
        </div>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="end_date" name="end_date" value="" required>
        </div>
    </div>
    <div class="form-group">
        <div class="control-label col-sm-3">
            <label for="comment">Пояснение</label>
        </div>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="comment" name="comment" value="" required>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <button class="btn btn-primary">Сохранить</button>
            <a href="{{ url()->previous() }}" class="btn btn-default">Назад</a>
        </div>
    </div>


</form>
@endsection

@section('scripts')
$(function () {

    $('#start_date').datetimepicker({
        locale: 'ru',
        viewMode: 'months',
        format: 'DD.MM.YYYY',
        minDate: moment()
    });

    $('#end_date').datetimepicker({
        locale: 'ru',
        viewMode: 'months',
        format: 'DD.MM.YYYY',
        useCurrent: false
    });


    $("#start_date").on("dp.change", function (e) {
        $('#end_date').data("DateTimePicker").minDate(e.date);
    });

    $("#end_date").on("dp.change", function (e) {
        $('#start_date').data("DateTimePicker").maxDate(e.date);
    });

});
@endsection
