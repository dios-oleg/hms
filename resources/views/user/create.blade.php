@extends('layouts.app')

@section('title', 'Новый пользователь')

@section('content')
<form method="POST" action="{{ route('users.store') }}" class="form-horizontal">
    {{ csrf_field() }}
    {{ method_field('POST') }}

    <!--TODO только почту, должность и роль. При создании отправляется ссылка на восстановление пароля. При пустой инфе, необх заполнить инфу на стр редактирования-->

    @if (count($errors) > 0)
        <div class="row">
            <div class="alert alert-danger" role="alert">
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
            <label for="email">E-Mail</label>
        </div>
        <div class="col-sm-9">

            <!--TODO копировать старый ввод-->

            <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>
    </div>

    <div class="form-group">
        <div class="control-label col-sm-3">
            <label for="position">Должность</label>
        </div>
        <div class="col-sm-9">

            <!--TODO копировать старый ввод-->

            <select class="selectpicker" id="position" name="position" required>
                @foreach($positions as $position)
                    <option value="{{ $position->id }}" {{ old('position') }}>
                        {{ $position->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

     <div class="form-group">
        <div class="control-label col-sm-3">
            <label for="role">Роль</label>
        </div>
        <div class="col-sm-9">

            <!--TODO копировать старый ввод-->

            <select class="selectpicker" id="role" name="role" required>
                @foreach($roles as $role)
                    <option value="{{ $role }}" {{ old('role') }}>
                        {{ $role }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <button class="btn btn-primary">Добавить пользователя</button>
            <a href="{{ url()->previous() }}" class="btn btn-default">Назад</a>
        </div>
    </div>
</form>
@endsection
