@if (session('success'))
    <div class="alert alert-success">
        @if ( isset($title) )
            {{ $title }}
        @else
            Информация успешно обновлена!
        @endif
    </div>
@endif
