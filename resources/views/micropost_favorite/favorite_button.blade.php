    @if (Auth::user()->is_favorites($micropost->id))
        {{-- 取り消しボタンのフォーム --}}
        {!! Form::open(['route' => ['microposts.unfavorite', $micropost->id], 'method' => 'delete']) !!}
            {!! Form::submit('Unfavorite', ['class' => "btn btn-success btn-sm"]) !!}
        {!! Form::close() !!}
    @else
        {{-- お気に入りボタンのフォーム --}}
        {!! Form::open(['route' => ['microposts.favorite', $micropost->id]]) !!}
            {!! Form::submit('favorite', ['class' => "btn btn-light btn-sm"]) !!}
        {!! Form::close() !!}
    @endif