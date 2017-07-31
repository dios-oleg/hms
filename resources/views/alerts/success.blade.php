@if (session('success'))
    <div class="alert alert-success">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        @if ( isset($title) )
            {{ $title }}
        @else
            Информация успешно обновлена!
        @endif
    </div>
@endif
