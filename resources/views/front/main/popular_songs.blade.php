<div class="featured pad">
    <div class="container">
        <!-- default heading -->
        <div class="default-heading">
            <!-- heading -->
            <h2>محبوب ترین موسیقی ها</h2>
        </div>
        <!-- featured album elements -->
        <div class="featured-element">
            <div class="row">
                @forelse ($popularSongs as $song)
                    <div class="col-md-3 col-sm-6">
                        <!-- featured item -->
                        <div class="featured-item ">
                            <!-- image container -->
                            <div class="figure">
                                <!-- image -->
                                <a href="{{ route('show.song', $song->slug) }}" class="text-decoration-none">
                                    <img class="img-responsive" style="height: 250px;" src="{{ $song->image ? $song->image->url() : asset('img/user/1.jpg') }}" alt="Song's cover" />
                                </a>
                                <!-- paragraph -->
                                {{-- <p> --}}
                                {{-- </p> --}}
                            </div>
                            <a href="{{ route('show.song', $song->slug) }}" class="text-decoration-none">
                                <div class="hero-playlist">
                                    <div class="album-details">
                                        <h4>{{ $song->name }}</h4>
                                        <h5>{{ $song->artist->name }}</h5>
                                        <br>
                                        @foreach ($song->tags as $tag)
                                            <a class="badge bg-success" href="{{ route('front.tags', $tag->slug) }}">{{ $tag->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    آهنگی در حال حاضر وجود ندارد!
                @endforelse
            </div>
            <h3><a href="{{ route('front.songs') }}">مشاهده بیشتر</a></h3>
        </div>
    </div>
</div>

