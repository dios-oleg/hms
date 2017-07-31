@if (count($errors) > 0)
    <div class="row">
        <div class="alert alert-danger" role="alert">
            @if( isset($title) )
                <div>
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <b>{{ $title }}</b>
                </div>
            @endif
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
