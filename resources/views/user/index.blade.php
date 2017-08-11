@extends('layouts.app')

@section('title', 'Список пользователей')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('users.create') }}" class="btn btn-success">Создать пользователя</a>
        </div>
    </div>

    <form method="GET" action="{{ route('users') }}" class="form-inline margin-top-10">
        @include('alerts.success', ['title' => 'Новый пользователь был успешно создан!'])

        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" placeholder="Введите Email" class="form-control" value=" {{ $request->email }}">
        </div>
        <div class="form-group">
            <label for="position">Должности</label>
            <select name="position" id="position" class="selectpicker" data-live-search="true" title="Выбирите должность">
                <option value="0">Все</option>
                @foreach($positions as $position)
                    <option value="{{ $position->id }}" {{ $request->position == $position->id ? 'selected' : '' }}>{{ $position->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            Поиск
        </button>
        <a href="{{ route('users') }}" class="btn btn-default">
            Сбросить
        </a>

        <div class="form-group">
            <label for="email">Количество найденых записей: </label>
            <p class="form-control-static">{{ $users->total() }}</ip>
        </div>

    </form>

    @if (count($users) > 0)
        <table class="table table-hover margin-top-10">
            <thead>
                <tr>
                    <th>#</th>
                    <th>
                        E-Mail
                        <a href="{{ route('users', ['sort=email', 'order='.($parameters['sort'] == 'email' && $parameters['order'] == 'asc' ? 'desc' : 'asc')] ) }}">
                            @if ($parameters['sort'] == 'email' && $parameters['order'] == 'asc')
                                <span class="glyphicon glyphicon-sort-by-alphabet-alt" aria-hidden="true"></span>
                            @else
                                <span class="glyphicon glyphicon-sort-by-alphabet" aria-hidden="true"></span>
                            @endif
                        </a>
                    </th>
                    <th>
                        Ф.И.О.
                        <a href="{{ route('users', ['sort=last_name', 'order='.($parameters['sort'] == 'last_name' && $parameters['order'] == 'asc' ? 'desc' : 'asc')] ) }}">
                            @if ($parameters['sort'] == 'last_name' && $parameters['order'] == 'asc')
                                <span class="glyphicon glyphicon-sort-by-alphabet-alt" aria-hidden="true"></span>
                            @else
                                <span class="glyphicon glyphicon-sort-by-alphabet" aria-hidden="true"></span>
                            @endif
                        </a>
                    </th>
                    <th>Должность</th>
                    <th>Роль</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr class="{{ $user->is_blocked == 1 ? 'danger' : '' }}">
                    <td> {{ $user->id }} </td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}"--> {{ $user->email }} </a>
                    </td>
                    <td>
                        {{ $user->last_name.' '.$user->first_name.' '.$user->patronymic }}
                    </td>

                    <td> {{ $user->position->name }} </td>
                    <td> {{ $user->role }} </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="text-info text-center padding-top-20">Пользователи не найдены</div>
    @endif

    <div class="text-center">
        {{ $users->appends($parameters)->links() }}
    </div>
@endsection
