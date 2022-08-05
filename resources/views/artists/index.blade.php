@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @auth
                <a class="btn btn-primary w-25" href="{{ route('artists.create') }}">ایجاد هنرمند</a>
            @endauth
            @foreach ($artists as $artist)
                <a href="{{ route('artists.show', $artist->slug) }}">{{ $artist->name }}:{{ $artist->albums_count }}</a><br>
            @endforeach
        </div>
    </div>
@endsection
