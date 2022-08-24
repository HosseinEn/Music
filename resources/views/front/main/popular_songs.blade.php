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
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <!-- featured item -->
                        <div class="featured-item m-5">
                            <!-- image container -->
                            <div class="figure">
                                <!-- image -->
                                <a href="{{ route('show.song', $song->slug) }}" class="text-decoration-none">
                                    <img class="img-responsive" 
                                        style="  display: block; margin-left: auto; margin-right: auto; height: 270px;"
                                        src="{{ $song->image ? $song->image->url() : asset('img/user/1.jpg') }}" alt="Song's cover" />
                                </a>
                            </div>
                            <a href="{{ route('show.song', $song->slug) }}" class="text-decoration-none">
                                <div class="hero-playlist">
                                    <div class="album-details">
                                        <h4>{{ $song->name }}</h4>
                                        <h5>{{ $song->artist->name }}</h5>
                                        <br>
                                        {{-- @foreach ($song->tags as $tag)
                                            <a class="badge bg-success" href="{{ route('front.tags', $tag->slug) }}">{{ $tag->name }}</a>
                                        @endforeach --}}
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    آهنگی در حال حاضر وجود ندارد!
                @endforelse
            </div>
            <h3><a class="btn btn-primary btn-lg" href="{{ route('front.songs') }}?order=popular">مشاهده بیشتر >></a></h3>
        </div>
    </div>
</div>
