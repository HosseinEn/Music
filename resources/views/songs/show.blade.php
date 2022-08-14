@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.home') }}">خانه</a></li>
            <li><a href="{{ route('songs.index') }}">لیست موسیقی ها</a></li>
            <li>نمایش اطلاعات {{ $song->name }}</li>
        </ol>
    </nav>
    <div class="row">
        <h1>{{ $song->name }}</h1>
        <div class="card mb-3">
            @if($song->image)
                <img src="{{ $song->image->url() }}" alt="Song image here" class="img-thumbnail" style="width: 100px;">
            @endif
            <div class="card-body">
              <h5 class="card-title">هنرمند:{{$song->artist->name}}</h5>
              @if($song->album)
                <p class="card-text">
                    آلبوم:
                    <a href="{{ route('albums.show', $song->album->slug) }}">{{ $song->album->name }}</a>
                </p>
              @endif
              @if(count($song->tags) !== 0)
                    <p class="card-text">
                        ژانر:
                        @foreach ($song->tags as $tag)
                            <a class="badge bg-success">{{ $tag->name }}</a>
                        @endforeach        
                    </p>
                @endif
                @if($song->songFiles()->quality128Exists())
                    <a href="{{ route('admin.download.song', $song->slug) }}?quality=128">
                        <button type="button" class="btn btn-success mt-3">Download 128kbps</button>
                    </a>
                @endif
                @if($song->songFiles()->quality320Exists())
                    <a href="{{ route('admin.download.song', $song->slug) }}?quality=320">
                        <button type="button" class="btn btn-success mt-3">Download 320kbps</button>
                    </a>
                @endif
            </div>
            
    </div>
</div>
@endsection