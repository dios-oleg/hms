<div class="container">
    <form method="GET" action="{{ route('users') }}" >
        <input type="text" id="email" name="email">
        <select name="position" id="position">
            <option value="">Все</option>
            @foreach($positions as $position)
                <option value="{{ $position->id }}">{{ $position->name }}</option>
            @endforeach
        </select>
        <input type="submit">
        <a href="{{ route('users', ['sort=name', 'order=asc']) }}">s</a>
    </form>
  @foreach ($users as $user)
    <a href="{{ route('view-user', $user->id) }}">{{ $user->first_name.' '.$user->last_name }}</a>
  @endforeach
</div>
{{ $users->currentPage() }}
{{ $users->appends($search)->links() }}

