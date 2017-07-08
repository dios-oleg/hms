@extends('layouts.app')

@section('title', 'Изменение параметров системы')

@section('content')
    <form class="form-horizontal" method="POST" action="{{ route('settings.update', $parameter['id']) }}">
        {{ csrf_field() }}
        <div class="form-group">
            <label class="control-label col-sm-3">Свойство</label>
            <div class="col-sm-9">
                <p class="form-control-static">{{ $parameter['title'] }}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3">Предыдущее значение</label>
            <div class="col-sm-9">
                <p class="form-control-static">{{ $parameter['value'] }}</p>
                <p class="help-block">Изменено {{ $parameter['created_at'] }}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3" for="value">Новое значение</label>
            <div class="col-sm-9">
                <input type="text" id="value" name="value" placeholder="Введите новое значение" class="form-control" required>
            </div>
        </div>
        
        @if (count($errors) > 0)
            
            <div class="row">
                <div class="col-sm-offset-3 col-sm-9">
                    <div class="alert alert-danger" role="alert">
                        <div><b>Ошибка! Запись не была обновлена!</b></div>
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
        
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <input class="btn btn-primary" type="submit">
                <a class="btn btn-default" href="{{ route('settings') }}">Назад</a>
            </div>
        </div>
    </form>
@endsection
