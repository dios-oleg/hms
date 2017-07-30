@extends('layouts.app')

@section('title', 'Редактирование должности | '.$position->name)

@section('content')
    <form action="{{ route('positions.delete', $position->id) }}" method="POST" id="position-delete">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
    </form>
    <form action="{{ route('positions.update', $position->id) }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        
        @include('alerts.errors', ['title' => 'Ошибка! Данные не были обновлены!'])
        @include('alerts.error', ['title' => session('title')])
        @include('alerts.success', ['title' => 'Должность была успешно обновлена!'])
        
        <div class="form-group">
            <div class="control-label col-sm-3">
                <label for="name">Должность</label>
            </div>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="name" name="name" value="{{ $position->name }}" required>
            </div>
        </div>
        
        <div class="form-group">
            <div class="control-label col-sm-3">
                <label for="name_print">Должность в родительном падаже</label>
            </div>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="name_print" name="name_print" value="{{ $position->name_print }}" required>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <button class="btn btn-primary">Обновить</button>
                <button class="btn btn-danger" form="position-delete">Удалить</button>
                <a href="{{ route('positions') }}" class="btn btn-default">Назад</a>
            </div>
            
        </div>
    </form>
@endsection
