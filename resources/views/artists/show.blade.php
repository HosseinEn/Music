@extends('layouts.app')

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
            هنرمند:{{ $artist->name }}<br>
            @if($artist->image)
                <img src="{{ $artist->image->url() }}" alt="Artist image here" class="img-thumbnail" style="width: 100px;">
            @endif
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
                        هنرمند هیچ آلبومی ندارد!
                    </li>
                @endforelse
            </ul>

            <hr class="mt-5">
            <h3 class="mt-5">تک موسیقی ها:</h3>
            <ul class="list-group">
                @forelse ($artist->songs as $song)
                    <li class="list-group-item">{{ $song->name }}</li>
                @empty
                    <li class="list-group-item">هنرمند آهنگ تکی ندارد!</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
