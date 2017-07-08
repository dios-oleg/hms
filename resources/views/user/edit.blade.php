@extends('layouts.app')

{{--TODO сделать проверку Если свой аккаунт, то один заголовок, если нет, то другой--}}
@section('title', 'Редактирование профиля - '.$user->first_name.' '.$user->last_name)

@section('content')
    <form method="POST" action="{{ route('users.update', $user->id) }}" class="form-horizontal">
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
        
        {{--Если Админ, то можно менять данные поля--}}
        @if (Auth::user()->can('is-leader'))
        <hr>
            <div class="form-group">
                <div class="control-label col-sm-3">
                    <label for="">Должность</label>
                </div>
                <div class="col-sm-9">
                    <select class="selectpicker">
                        @foreach($positions as $position)
                            {{--TODO выделить текущую должность--}}
                            <option>$position->name</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="blocked" name="blocked"> Заблокирован
                        </label>
                      </div>
                    </div>
                </div>
        @else
            <div class="form-group">
                <div class="control-label col-sm-3">
                    <label>Должность</label>
                </div>
                <div class="col-sm-9">
                    <p class="form-control-static">{{ $user->position }}</p>
                </div>
            </div>
        @endif
        
        {{--TODO Только если владелец аккаунта, иначе только сброс пароля--}}
        <hr>
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
                <label for="password">Еще раз пароль</label>
            </div>
            <div class="col-sm-9">
                <input type="password" class="form-control" id="password_repeat" name="password_repeat" value="">
            </div>
        </div>
        
        <div class="col-sm-offset-3 col-sm-9">
            <button class="btn btn-primary">Обновить</button>
            {{--TODO вернуться на главную страницу, если пользователь или на страницу пользователей, если админ--}}
            <a href="{{ route('home') }}" class="btn btn-default">Назад</a>
        </div>
        
        
        {{--TODO выделить в отдельный шаблон и передавать туда заголовок--}}
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
    </form>
@endsection
