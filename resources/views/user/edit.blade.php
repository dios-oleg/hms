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
                
                {{--TODO проверка на наличие ошибок. можно в отдельный файл с передачей аргументов--}}
                @if( $errors->has('first_name') )
                <br><div class="alert alert-danger" role="alert">
                    <ul>
                        @foreach($errors->get('first_name') as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
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
                            <option value="{{ $position->id }}" {{ ($position->id == $user->position->id) ? 'selected' : '' }}>
                                {{ $position->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="control-label col-sm-3">
                    <label for="blocked">Блокировка</label>
                </div>
                <div class="col-sm-9">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="blocked" name="blocked" {{ $user->is_blocked ? 'checked' : '' }}> Заблокирован
                        </label>
                      </div>
                    </div>
            </div>
            {{--отображать или активировать только когда статус блокировки true или нажимаешь на галочку true--}}
            <div class="form-group">
                <div class="control-label col-sm-3">
                    <label for="comment">Причина блокировки</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="comment" name="comment" value={{ $user->comment }}>
                </div>
            </div>
            <div class="form-group">
                <div class="control-label col-sm-3">
                    <label for="roles">Роль</label>
                </div>
                <div class="col-sm-9">
                    <select class="selectpicker" id="roles" name="roles">
                        @foreach($roles as $role)
                            <option value="{{ $role }}" {{ ($role == $user->role) ? 'selected' : '' }}>
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
                    <a class="btn btn-default" href="{{ route('users.reset', $user) }}">Сбросить пароль</a>
                </div>
            </div>
        @endif
        
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <button class="btn btn-primary">Обновить</button>
                <a href="{{ url()->previous() }}" class="btn btn-default">Назад</a>
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
