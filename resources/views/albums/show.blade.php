@extends('layouts.app')

@section('title', 'نمایش آلبوم')

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
            <div class="card mb-3">
                <img class="card-img-top" src="{{ $album->image->url() }}" alt="Card image cap">
                <div class="card-body">
                    <h2 class="card-title">{{ $album->name }}</h2>
                    <hr>
                    <p class="card-text">
                        <b>هنرمند: </b>
                        <a href="{{ route('artists.show', $album->artist->slug) }}">
                            {{ $album->artist->name }}
                        </a>
                    </p>
                    <hr>
                    <p class="card-text">
                        <b>تاریخ انتشار توسط هنرمند:</b>
                        {{(new Carbon\Carbon($album->released_date))->format('d-m-Y')}}
                    </p>
                    <hr>
                    <p class="card-text">
                        <b>ژانر ها:</b>
                        @foreach ($album->tags as $tag)
                            <a class="badge bg-success">{{ $tag->name }}</a>
                        @endforeach
                    </p>
                    <hr>
                    <p class="card-text">
                        <b>طول آلبوم:</b>
                        {{$album->duration}}
                    </p>
                </div>
            </div>
            <h1>موسیقی ها:</h1>
            <ul class="list-group">
                @forelse ($album->songs as $song)
                    <a class="text-dark" style="font-size: 20px;"
                        href="{{ route('songs.show', $song->slug) }}">
                        <li class="list-group-item" name="{{ $song->slug }}">
                            {{ $song->name }}
                        </li>
                    </a>
                @empty
                    <li class="list-group-item">
                        آلبوم هیچ موسیقی ندارد!
                    </li>
                @endforelse
            </ul>

        </div>

@endsection
