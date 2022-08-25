@extends('layouts.app')

@section('title', 'مشاهده ژانر')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.home') }}">خانه</a></li>
                <li><a href="{{ route('albums.index') }}">لیست آلبوم ها</a></li>
                <li>نمایش اطلاعات {{ $album->name }}</li>
            </ol>
        </nav>
        <div class="row">
            <h1>{{ $album->name }}</h1><br>
            @if($album->image)
                <img src="{{ $album->image->url() }}" alt="Album image here" class="img-thumbnail" style="width: 100px;">
            @endif
            <h3>هنرمند:<a href="{{ route('artists.show', $album->artist->slug) }}">{{ $album->artist->name }}</a></h3>
            ژانر:
            <br>
            @foreach ($album->tags as $tag)
                <p><a class="badge bg-success">{{ $tag->name }}</a></p>
            @endforeach
            <hr>
            <h1>موسیقی ها:</h1>
            <ul class="list-group mt-3">
                @forelse ($album->songs as $song)
                    <li class="list-group-item">
                        <h5>{{ $song->name }}</h5>
                    </li>
                @empty
                    <li class="list-group-item">
                        آلبوم هیچ موسیقی ندارد!
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
