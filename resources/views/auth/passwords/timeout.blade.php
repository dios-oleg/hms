@extends('layouts.app')

@section('title', 'Восстановление пароля')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Восстановление пароля</div>
                <div class="panel-body text-justify">
                    Скрок действия ссылки истек. <a href="{{ route('auth.recovery') }}">Заполните форму</a> для отправления на почту нового сообщения о восстановлении пароля.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
