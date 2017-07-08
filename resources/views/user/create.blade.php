@extends('layouts.app')

@section('title', 'Новый сотрудник')

@section('content')
<form method="POST" action="{{ route('users.create') }}">
    {{ csrf_field() }}
    <div>
        <label for="first_name">Имя</label>
        <input type="text" name="first_name" id="first_name" required>
    </div>
    <div>
        <label for="last_name">Фамилия</label>
        <input type="text" name="last_name" id="last_name" required>
    </div>
    <div>
        <label for="last_name_print">Фамилия в род. падеже</label>
        <input type="text" name="last_name_print" id="last_name_print" required>
    </div>
    <div>
        <label for="patronymic">Отчество</label>
        <input type="text" name="patronymic" id="patronymic" required>
    </div>
    <div>
        <label for="address">Адрес проживания</label>
        <input type="text" name="address" id="address" required>
    </div>
    <div>
        <label for="email">E-Mail</label>
        <input type="text" name="email" id="email" required>
    </div>
    <select name="position_id" id="position_id">
        @foreach( $positions as $position )
            <option value="{{ $position->id }}">{{ $position->name }}</option>
        @endforeach
    </select>
    <!--div>
        <label for="position_id">Должность</label>
        <input type="text" name="position_id" id="position_id" required>
    </div-->
    <input type="submit">
</form>
@endsection
