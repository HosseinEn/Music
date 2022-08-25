@extends('layouts.app')

@section('title', $artist->name)

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.home') }}">خانه</a></li>
                <li><a href="{{ route('artists.index') }}">لیست هنرمندان</a></li>
                <li>نمایش اطلاعات {{ $artist->name }}</li>
            </ol>
        </nav>
        <div class="row">
            <div class="card mb-3">
                <img class="card-img-top" src="{{ $artist->image->url() }}" alt="Card image cap">
                <div class="card-body">
                    <h2 class="card-title">{{ $artist->name }}</h2>
                </div>
            </div>

            <h1>موسیقی ها:</h1>
            <ul class="list-group">
                @forelse ($artist->songs as $song)
                    <a class="text-dark" style="font-size: 20px;"
                        href="{{ route('songs.show', $song->slug) }}">
                        <li class="list-group-item" name="{{ $song->slug }}">
                            {{ $song->name }}
                        </li>
                    </a>
                @empty
                    <li class="list-group-item">
                        هنرمند هیچ موسیقی ندارد!
                    </li>
                @endforelse
            </ul>

            <h1>آلبوم ها:</h1>
            <ul class="list-group">
                @forelse ($artist->albums as $album)
                    <a class="text-dark" style="font-size: 20px;"
                        href="{{ route('albums.show', $album->slug) }}">
                        <li class="list-group-item" name="{{ $album->slug }}">
                            {{ $album->name }}
                        </li>
                    </a>
                @empty
                    <li class="list-group-item">
                        هنرمند هیچ آلبومی ندارد!
                    </li>
                @endforelse
            </ul>
        </div>

@endsection
