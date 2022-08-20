@extends("front.layouts.index")

@section("content")
<div class="featured pad" id="">
    <div class="container">
        <!-- default heading -->
        <div class="default-heading">
            <!-- heading -->
            @include('front.main.search')
        </div>
        <!-- featured album elements -->
        <div class="featured-element">
            <div class="row">
                @forelse ($searchResults as $item)
                    <div class="col-md-3 col-sm-6">
                        <!-- featured item -->
                        <div class="featured-item ">
                            <!-- image container -->
                            <div class="figure">
                                <!-- image -->
                                @if(get_class($item) === "App\Models\Album")
                                    <a href="{{ route('show.album', $item->slug) }}" class="text-decoration-none">
                                @elseif(get_class($item) === "App\Models\Song")
                                    <a href="{{ route('show.song', $item->slug) }}" class="text-decoration-none">
                                @else
                                    <a href="{{ route('show.artist', $item->slug) }}" class="text-decoration-none">
                                @endif
                                    <img class="img-responsive" src="{{  $item->image ? $item->image->url() : asset('img/user/1.jpg')  }}" alt="Song's cover" />
                                </a>
                                <!-- paragraph -->
                                @if(get_class($item) !== "App\Models\Artist")
                                    @foreach ($item->tags as $tag)
                                        <a class="badge bg-success" href="{{ route('front.tags', $tag->slug) }}">{{ $tag->name }}</a>
                                    @endforeach
                                @endif
                            </div>
                            <div class="hero-playlist">
                                <div class="album-details">
                                    @if(get_class($item) === "App\Models\Album")
                                        <a href="{{ route('show.album', $item->slug) }}" class="text-decoration-none">
                                    @elseif(get_class($item) === "App\Models\Song")
                                        <a href="{{ route('show.song', $item->slug) }}" class="text-decoration-none">
                                    @else
                                        <a href="{{ route('show.artist', $item->slug) }}" class="text-decoration-none">
                                    @endif
                                        <h4>{{ $item->name }}</h4>
                                        @if(get_class($item) !== "App\Models\Artist")
                                            <h5>{{ $item->artist->name }}</h5>
                                        @endif
                                    </a>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>          
                @empty
                    <h2>نتیجه ای یافت نشد!</h2>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection