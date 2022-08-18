@extends('front.layouts.index')

@section('content')
    <div class="featured pad" id="">
        <div class="container">
            <!-- default heading -->
            <div class="default-heading">
                <!-- heading -->
                <h2>آلبوم های {{ $artist->name }}</h2>
            </div>
            <!-- featured album elements -->
            <div class="featured-element">
                <div class="row">
                    @forelse ($artist->albums as $album)
                        <div class="col-md-3 col-sm-6">
                            <!-- featured item -->
                            <div class="featured-item ">
                                <!-- image container -->
                                <div class="figure">
                                    <!-- image -->
                                    <a href="{{ route('show.album', $album->slug) }}" class="text-decoration-none">
                                        <img class="img-responsive" src="{{ $album->image ? $album->image->url() : asset('img/user/1.jpg') }}" alt="Song's cover" />
                                    </a>
                                    <!-- paragraph -->
                                    @foreach ($album->tags as $tag)
                                        <a class="badge bg-success">{{ $tag->name }}</a>
                                    @endforeach
                                </div>
                                <div class="hero-playlist">
                                    <div class="album-details">
                                        <!-- title -->
                                        <a href="{{ route('show.album', $album->slug) }}" class="text-decoration-none">
                                            <h4>{{ $album->name }}</h4>
                                            <!-- composed by -->
                                            <h5>{{ $album->artist->name }}</h5>
                                            <!-- paragraph -->
                                        </a>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>          
                    @empty
                        این هنرمند تا به حال آلبومی منتشر نکرده است!
                    @endforelse
                </div>  
            </div>
        </div>
    </div>
    <div class="featured pad" id="">
        <div class="container">
            <!-- default heading -->
            <div class="default-heading">
                <!-- heading -->
                <h2>موسیقی های {{$artist->name}}</h2>
            </div>
            <!-- featured album elements -->
            <div class="featured-element">
                <div class="row">
                    @forelse ($artist->songs as $song)
                        <div class="col-md-3 col-sm-6">
                            <!-- featured item -->
                            <div class="featured-item ">
                                <!-- image container -->
                                <div class="figure">
                                    <!-- image -->
                                    <a href="{{ route('show.song', $song->slug) }}" class="text-decoration-none">
                                        <img class="img-responsive" src="{{ $song->image ? $song->image->url() : asset('img/user/1.jpg') }}" alt="Song's cover" />
                                    </a>
                                    @foreach ($song->tags as $tag)
                                        <a class="badge bg-success" href="{{ route('front.tags', $tag->slug) }}">{{ $tag->name }}</a>
                                    @endforeach
                                </div>
                                <div class="hero-playlist">
                                    <div class="album-details">
                                        <a href="{{ route('show.song', $song->slug) }}" class="text-decoration-none">
                                            <h4>{{ $song->name }}</h4>
                                            <h5>{{ $song->artist->name }}</h5>
                                        </a>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>          
                    @empty
                        این هنرمند موسیقی ای منتشر نکرده است!
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection