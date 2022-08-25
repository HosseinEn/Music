@extends('layouts.app')

@section('title', 'مشاهده موسیقی')

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
        <div class="card mb-3">
            <img class="card-img-top" src="{{ $song->image->url() }}" alt="Card image cap">
            <div class="card-body">
                <h2 class="card-title">{{ $song->name }}</h2>
                <hr>
                <p class="card-text">
                    <b>هنرمند: </b>
                    <a href="{{ route('artists.show', $song->artist->slug) }}">
                        {{ $song->artist->name }}
                    </a>
                </p>
                @if($song->album)
                    <hr>
                    <p class="card-text">
                        آلبوم: 
                        <a href="{{ route('albums.show', $song->album->slug) }}">
                            {{ $song->album->name }}
                        </a>
                    </p>
                @endif
                <hr>
                <p class="card-text">
                    <b>تاریخ انتشار توسط هنرمند:</b>
                    {{(new Carbon\Carbon($song->released_date))->format('d-m-Y')}}
                </p>
                <hr>
                <p class="card-text">
                    <b>ژانر ها:</b>
                    @foreach ($song->tags as $tag)
                        <a class="badge bg-success">{{ $tag->name }}</a>
                    @endforeach
                </p>
                <hr>
                <p class="card-text">
                    <b>طول موسیقی:</b>
                     {{$song->songFiles->first()->duration}}
                </p>
                <hr>
                <p class="card-text">
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
                </p>
            </div>
        </div>
    </div>
</div>
@endsection