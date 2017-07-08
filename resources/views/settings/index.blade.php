@extends('layouts.app')

@section('title', 'Параметры системы')

@section('content')
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Свойство</th>
                <th class="text-center">Значение</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($parameters as $parameter)
            <tr>
                <td>
                    {{ $parameter['title'] }} 
                    <span class="text-muted">
                        {{-- TODO скрывать это поле и отображать при наведении на строку --}}
                        <a href="{{ route('settings.edit', $parameter['id']) }}">править</a>
                    </span> 
                </td>
                <td class="text-center">{{ $parameter['value'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
