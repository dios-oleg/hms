@extends('layouts.app')

@section('title', 'Создание должности')

@section('content')
    <form action="{{ route('positions.store') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}
        
        @include('alerts.errors', ['title' => 'Ошибка! Должность не была добавлена!'])
        
        <div class="form-group">
            <div class="control-label col-sm-3">
                <label for="name">Должность</label>
            </div>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>
        </div>
        
        <div class="form-group">
            <div class="control-label col-sm-3">
                <label for="name_print">Должность в родительном падаже</label>
            </div>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="name_print" name="name_print" value="{{ old('name_print') }}" required>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <button class="btn btn-primary">Сохранить</button>
                <a href="{{ route('positions') }}" class="btn btn-default">Назад</a>
            </div>
            
        </div>
    </form>
@endsection
