@if (count($errors) > 0)
    <div class="row">
        <div class="alert alert-danger" role="alert">
            @if( isset($title) )
                <div><b>{{ $title }}</b></div>
            @endif
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
