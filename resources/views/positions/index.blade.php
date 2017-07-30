@extends('layouts.app')

@section('title', 'Справочник должностей')

@section('content')
    @include('alerts.success', ['title' => session('title')])
    <a href="{{ route('positions.create') }}" class="btn btn-success">Создать должность</a>

    <table class="table table-hover margin-top-10">
        <thead>
            <tr>
                <th>#</th>
                <th>Должность</th>
                <th>Должность в р.п.</th>
                <th> </th>
            </tr>
        </thead>
        <tbody>
            @foreach($positions as $position)
                <tr>
                    <td>{{ $position->id }}</td>
                    <td>{{ $position->name }}</td>
                    <td>{{ $position->name_print }}</td>
                    <td>
                        <a href="{{ route('positions.edit', $position->id) }}">
                            <span class="glyphicon glyphicon-eye-open"  aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $positions->links() }}

@endsection
