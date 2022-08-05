@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            هنرمند:{{ $artist->name }}<br>
            <img src="" alt="Artist image here">
            <h3>آلبوم ها:</h3>
            <ul class="list-group mt-3">
                @forelse ($artist->albums as $album)
                    <li class="list-group-item active">
                        <h5>{{ $album->name }}</h5>
                    </li>
                    @foreach ($album->songs as $song)
                        <li class="list-group-item">
                            {{ $song->name }}
                        </li>
                    @endforeach
                @empty
                    <li class="list-group-item">
                        Artist has no album!
                    </li>
                @endforelse
            </ul>

            <hr class="mt-5">
            <h3 class="mt-5">تک موسیقی ها:</h3>
            <ul class="list-group">
                @forelse ($artist->songs as $song)
                    <li class="list-group-item">{{ $song->name }}</li>
                @empty
                    <li class="list-group-item">Artist has no solo song!</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
