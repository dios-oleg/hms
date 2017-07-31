@if (session('error'))
    <div class="alert alert-danger">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        @if ( isset($title) )
            {{ $title }}
        @else
            Информация не была обновлена!
        @endif
    </div>
@endif
