@if (session('error'))
    <div class="alert alert-danger">
        @if ( isset($title) )
            {{ $title }}
        @else
            Информация не была обновлена!
        @endif
    </div>
@endif
