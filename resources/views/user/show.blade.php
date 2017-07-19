@extends('layouts.app')

{{--TODO сделать проверку Если свой аккаунт, то один заголовок, если нет, то другой--}}
@section('title', 'Редактирование профиля - '.$user->first_name.' '.$user->last_name)

@section('content')
    <div class="form-horizontal">
        {{ csrf_field() }}
        <div class="form-group">
            <div class="control-label col-sm-3">
                <label>Email</label>
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
                <p class="form-control-static">{{ $user->first_name }}</p>
            </div>
        </div>
        <div class="form-group">
            <div class="control-label col-sm-3">
                <label for="last_name">Фамилия</label>
            </div>
            <div class="col-sm-9">
                <p class="form-control-static">{{ $user->last_name }}</p>
            </div>
        </div>
        <div class="form-group">
            <div class="control-label col-sm-3">
                <label for="last_name_print">Фамилия в родительном падеже</label>
            </div>
            <div class="col-sm-9">
                <p class="form-control-static">{{ $user->last_name_print }}</p>
            </div>
        </div>
        <div class="form-group">
            <div class="control-label col-sm-3">
                <label for="patronymic">Отчество</label>
            </div>
            <div class="col-sm-9">
                <p class="form-control-static">{{ $user->patronymic }}</p>
            </div>
        </div>
        <div class="form-group">
            <div class="control-label col-sm-3">
                <label for="address">Адрес</label>
            </div>
            <div class="col-sm-9">
                <p class="form-control-static">{{ $user->address }}</p>
            </div>
        </div>
        <div class="form-group">
            <div class="control-label col-sm-3">
                <label for="positions">Должность</label>
            </div>
            <div class="col-sm-9">
                <p class="form-control-static">{{ $user->position->name }}</p>
            </div>
        </div>
        <div class="form-group">
            <div class="control-label col-sm-3">
                <label for="positions">Статус блокировки</label>
            </div>
            <div class="col-sm-9">
                <p class="form-control-static">
                    {{ $user->is_blocked ? 'Заблокирован' : 'Не заблокирован' }}
                </p>
            </div>
        </div>
        <div class="form-group">
            <div class="control-label col-sm-3">
                <label for="roles">Роль</label>
            </div>
            <div class="col-sm-9">
                <p class="form-control-static">{{ $user->role }}</p>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                @if (Route::currentRouteName() == 'users.account')
                    <a href="{{ route('users.account.edit') }}" class="btn btn-primary">Редактировать</a>
                    <a class="btn btn-default" href="{{ route('users.password') }}">Изменить пароль</a>
                    <a href="{{ route('app') }}" class="btn btn-default">Назад</a>
                @else
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Редактировать</a>
                    <a class="btn btn-default" href="{{ route('users.reset', $user) }}">Сбросить пароль</a>
                    <a href="{{ route('users') }}" class="btn btn-default">Назад</a>
                @endif
            </div>
        </div>

    </div>
@endsection
