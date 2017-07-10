@extends('layouts.app')

@section('title', 'Список пользователей')

@section('content')
    {{-- TODO сделать отдельное представление --}}
    <form method="GET" action="{{ route('users') }}" class="form-inline">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" placeholder="Введите Email" class="form-control" value=" {{ $request->email }}">
        </div>
        <div class="form-group">
            {{-- TODO список bootstrap --}}
            <label for="position">Должности</label>
            <select name="position" id="position" class="selectpicker" data-live-search="true" title="Выбирите должность">
                <option value="0">Все</option>
                @foreach($positions as $position)
                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="btn btn-default">
            <!--span class="glyphicon glyphicon-search" aria-hidden="true"></span-->
            Поиск
        </button>
        
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
                        Email
                        {{-- TODO можно в отдельный шаблон --}}
                        <a href="{{ route('users', ['sort=email', 'order='.($table_sort['sort'] == 'email' ? $table_sort['order'] : 'desc')] ) }}">
                            @if ($table_sort['sort'] == 'email' && $table_sort['order'] == 'asc')
                                <span class="glyphicon glyphicon-sort-by-alphabet-alt" aria-hidden="true"></span>
                            @else
                                <span class="glyphicon glyphicon-sort-by-alphabet" aria-hidden="true"></span>
                            @endif
                        </a>
                    </th>
                    <th>
                        Ф.И.О.
                        {{-- TODO можно в отдельный шаблон --}}
                        <a href="{{ route('users', ['sort=name', 'order='.($table_sort['sort'] == 'name' ? $table_sort['order'] : 'desc')] ) }}">
                            @if ($table_sort['sort'] == 'name' && $table_sort['order'] == 'asc')
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
                        <a href="{{ route('users.show', $user->id) }}"--> {{ $user->email }} </a>
                    </td>
                    <td>
                        <!--a href="{{ route('users.show', $user->id) }}"--> {{ $user->first_name.' '.$user->last_name }} <!--/a-->
                    </td>
                    
                    <td> {{ $user->position->name }} </td>
                    <td> {{ $user->role }} </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        {{-- добавить отступ--}}
        <div class="text-info text-center padding-top-20">Пользователи не найдены</div>
    @endif
    
    <div class="text-center">
        {{ $users->appends($search)->links() }}
    </div>
@endsection
