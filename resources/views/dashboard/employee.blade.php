@extends('layouts.app')

@section('title', 'HMS')

@section('content')
Основной интерфейс системы. В нём пользователь должен иметь возможность просматривать, добавлять, редактировать и удалять заявки на отпуск.
табличный - список заявок:
дата подачи заявки;
интервал заявки (дата начала и дата окончания отпуска);
статус.
<div id="calendar"></div>
@endsection

@section('scripts_list')
  <script src="{{ asset('js/employee_dashboard.min.js') }}"></script>
@endsection
