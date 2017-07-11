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
                    <label for="positions">Должность</label>
                </div>
                <div class="col-sm-9">
                    <select class="selectpicker" id="positions" name="positions">
                        @foreach($positions as $position)
                            <option {{ ($position->id == $user->position->id) ? 'selected' : '' }}>
                                {{ $position->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="blocked" name="blocked" {{ $user->is_blocked ? 'checked' : '' }}> Заблокирован
                        </label>
                      </div>
                    </div>
            </div>
            <div class="form-group">
                <div class="control-label col-sm-3">
                    <label for="roles">Роль</label>
                </div>
                <div class="col-sm-9">
                    <select class="selectpicker" id="roles" name="roles">
                        @foreach($roles as $role)
                            <option {{ $role }} {{ ($role == $user->role) ? 'selected' : '' }}>
                                {{ $role }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        @else
            <div class="form-group">
                <div class="control-label col-sm-3">
                    <label>Текущая должность</label>
                </div>
                <div class="col-sm-9">
                    <p class="form-control-static">{{ $user->position->name }}</p>
                </div>
            </div>
        @endif
        
        {{--TODO Только если владелец аккаунта, иначе только сброс пароля--}}
        <hr>
        @if (Auth::user()->id == $user->id)
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
        @else
            <div class="form-group">
                <div class="control-label col-sm-3">
                        <label for="password">Пароль</label>
                </div>
                <div class="col-sm-9">
                    <a class="btn btn-default" href="{{ route('auth.reset', $user->email) }}">Сбросить пароль</a>
                </div>
            </div>
        @endif
        
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <button class="btn btn-primary">Обновить</button>
                {{-- url()->previous()  --}}
                @if (Auth::user()->role == $roles['LEADER'])
                    <a href="{{ route('users') }}" class="btn btn-default">Назад</a>
                @else
                    <a href="{{ route('users.account') }}" class="btn btn-default">Назад</a>
                @endif

            </div>
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
