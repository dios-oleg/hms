@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">First user</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('first') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="first_name" class="col-md-4 control-label">Имя</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>

                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name" class="col-md-4 control-label">Фамилия</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('patronymic') ? ' has-error' : '' }}">
                            <label for="patronymic" class="col-md-4 control-label">Отчество</label>

                            <div class="col-md-6">
                                <input id="patronymic" type="text" class="form-control" name="patronymic" value="{{ old('patronymic') }}" required>

                                @if ($errors->has('patronymic'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('patronymic') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('last_name_print') ? ' has-error' : '' }}">
                            <label for="last_name_print" class="col-md-4 control-label">Фамилия в родительном падеже</label>

                            <div class="col-md-6">
                                <input id="last_name_print" type="text" class="form-control" name="last_name_print" value="{{ old('last_name_print') }}" required>

                                @if ($errors->has('last_name_print'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name_print') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <!--list of the positions-->
                        
                        <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
                            <label for="position" class="col-md-4 control-label">Должность</label>

                            <div class="col-md-6">
                                <input id="position" type="text" class="form-control" name="position" value="{{ old('last_name_print') }}" required>

                                @if ($errors->has('position'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('position') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('position_print') ? ' has-error' : '' }}">
                            <label for="position_print" class="col-md-4 control-label">Должность в родительном падеже</label>

                            <div class="col-md-6">
                                <input id="position_print" type="text" class="form-control" name="position_print" value="{{ old('last_name_print') }}" required>

                                @if ($errors->has('position_print'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('position_print') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="address" class="col-md-4 control-label">Адрес</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" required>

                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Пароль</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Еще раз пароль</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Регистрация
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
