@extends('layouts.app')

@section('title', 'Изменение пароля')

@section('content')
<form class="form-horizontal" action="{{ route('users.password.update') }}" method="POST">
    {{ csrf_field() }}
    @if (count($errors) > 0)
            <div class="row">
                    <div class="alert alert-danger" role="alert">
                        <div><b>Ошибка! Запись не была обновлена!</b></div>
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
            </div>
        @endif
        
    <div class="form-group">
        <div class="control-label col-sm-3">
            <label for="old_password">Текущий пароль</label>
        </div>
        <div class="col-sm-9">
            <input type="password" class="form-control" id="old_password" name="old_password" value="">
        </div>
    </div>
    <div class="form-group">
        <div class="control-label col-sm-3">
            <label for="password">Новый пароль</label>
        </div>
        <div class="col-sm-9">
            <input type="password" class="form-control" id="password" name="password" value="">
        </div>
    </div>
    <div class="form-group">
        <div class="control-label col-sm-3">
            <label for="password_confirmation">Еще раз пароль</label>
        </div>
        <div class="col-sm-9">
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <button class="btn btn-primary">Обновить пароль</button>
            <a href="{{ route('users.account') }}" class="btn btn-default">Назад</a>
        </div>
    </div>
</form>
@endsection
