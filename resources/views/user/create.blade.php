@extends('layouts.app')

@section('title', 'Новый пользователь')

@section('content')
<form method="POST" action="{{ route('users.store') }}" class="form-horizontal">
    {{ csrf_field() }}

    @include('alerts.errors', ['title' => 'Ошибка! Пользователь не был добавлен!'])

    <div class="form-group">
        <div class="control-label col-sm-3">
            <label for="email">E-Mail</label>
        </div>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>
    </div>

    <div class="form-group">
        <div class="control-label col-sm-3">
            <label for="position">Должность</label>
        </div>
        <div class="col-sm-9">
            <select class="selectpicker" id="position" name="position" required>
                @foreach($positions as $position)
                    <option value="{{ $position->id }}" {{ old('position') == $position->id ? 'selected' : '' }}>
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
            <select class="selectpicker" id="role" name="role" required>
                @foreach($roles as $role)
                    <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                        {{ $role }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <button class="btn btn-primary">Добавить пользователя</button>
            <a href="{{ route('users') }}" class="btn btn-default">Назад</a>
        </div>
    </div>
</form>
@endsection
