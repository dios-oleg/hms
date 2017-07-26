
@extends('layouts.app')

@section('title', 'Профиль')

@section('content')
    <form method="POST" action="{{ route('profile.update') }}" class="form-horizontal">
        @include('alerts.success')

        {{ csrf_field() }}
        {{ method_field('PUT') }}

        @include('alerts.errors', ['title' => 'Ошибка! Данные не были обновлены!'])

        <div class="form-group">
            <div class="control-label col-sm-3">
                <label>E-Mail</label>
            </div>
            <div class="col-sm-9">
                <p class="form-control-static">{{ $user->email }}</p>
            </div>
        </div>

        <div class="form-group">
            <div class="control-label col-sm-3">
                <label for="first_name">Имя</label>
            </div>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $user->first_name }}" required>
            </div>
        </div>
        <div class="form-group">
            <div class="control-label col-sm-3">
                <label for="last_name">Фамилия</label>
            </div>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $user->last_name }}" required>
            </div>
        </div>
        <div class="form-group">
            <div class="control-label col-sm-3">
                <label for="last_name_print">Фамилия в родительном падеже</label>
            </div>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="last_name_print" name="last_name_print" value="{{ $user->last_name_print }}" required>
            </div>
        </div>
        <div class="form-group">
            <div class="control-label col-sm-3">
                <label for="patronymic">Отчество</label>
            </div>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="patronymic" name="patronymic" value="{{ $user->patronymic }}" required>
            </div>
        </div>
        <div class="form-group">
            <div class="control-label col-sm-3">
                <label for="address">Адрес</label>
            </div>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}" required>
            </div>
        </div>

        <div class="form-group">
            <div class="control-label col-sm-3">
                <label>Должность</label>
            </div>
            <div class="col-sm-9">
                <p class="form-control-static">{{ $user->position->name }}</p>
            </div>
        </div>
        <div class="form-group">
            <div class="control-label col-sm-3">
                <label>Роль</label>
            </div>
            <div class="col-sm-9">
                <p class="form-control-static">{{ $user->role }}</p>
            </div>
        </div>

        <hr>

        <div class="form-group">
            <div class="control-label col-sm-3">
                <label for="old_password">Текущий пароль</label>
            </div>
            <div class="col-sm-9">
                <input type="password" class="form-control" id="old_password" name="old_password">
            </div>
        </div>
        <div class="form-group">
            <div class="control-label col-sm-3">
                <label for="password">Новый пароль</label>
            </div>
            <div class="col-sm-9">
                <input type="password" class="form-control" id="password" name="password">
            </div>
        </div>
        <div class="form-group">
            <div class="control-label col-sm-3">
                <label for="password_confirmation">Подтверждение нового пароля</label>
            </div>
            <div class="col-sm-9">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>
        </div>

        <hr>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <button class="btn btn-primary">Обновить информацию</button>
                <a href="{{ url()->previous() }}" class="btn btn-default">Назад</a>
            </div>
        </div>
    </form>

@endsection
