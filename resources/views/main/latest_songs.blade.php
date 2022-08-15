<div class="featured pad" id="latestsongs">
    <div class="container">
        <!-- default heading -->
        <div class="default-heading">
            <!-- heading -->
            <h2>جدیدترین موسیقی ها</h2>
        </div>
        <!-- featured album elements -->
        <div class="featured-element">
            <div class="row">
                @forelse ($latestSongs as $song)
                    <div class="col-md-4 col-sm-6">
                        <!-- featured item -->
                        <div class="featured-item ">
                            <!-- image container -->
                            <div class="figure">
                                <!-- image -->
                                <img class="img-responsive" src="{{ $song->image->url() }}" alt="Song's cover" />
                                <!-- paragraph -->
                                <p>
                                    @foreach ($song->tags as $tag)
                                        <a class="badge bg-success" href="{{ route('front.tags', $tag->slug) }}">{{ $tag->name }}</a>
                                    @endforeach
                                </p>
                            </div>
                            <div class="hero-playlist">
                                <div class="album-details">
                                    <!-- title -->
                                    <h4>{{ $song->name }}</h4>
                                    <!-- composed by -->
                                    <h5>{{ $song->artist->name }}</h5>
                                    <!-- paragraph -->

                                    <br>
                                </div>
                            </div>
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

