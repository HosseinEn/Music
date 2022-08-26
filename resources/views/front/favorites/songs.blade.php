<div class="featured pad" id="">
    <div class="container">
        <!-- default heading -->
        <div class="default-heading">
            <!-- heading -->
            <h2>موسیقی های مورد علاقه شما</h2>
        </div>
        <!-- featured album elements -->
        <div class="featured-element">
            <div class="row">
                @forelse ($songs as $song)
                    <div class="col-md-3 col-sm-6">
                        <!-- featured item -->
                        <div class="featured-item ">
                            <!-- image container -->
                            <div class="figure">
                                <!-- image -->
                                <a href="{{ route('show.song', $song->slug) }}" class="text-decoration-none">
                                    <img class="img-responsive" style="display: block; margin-left: auto; margin-right: auto; height: 270px;" src="{{ $song->image ? $song->image->url() : asset('img/user/1.jpg') }}" alt="Song's cover" />
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
                    شما موسیقی را به علاقه مندی های خود اضافه نکردید! <a href="{{ route('front.songs') }}">مشاهده موسیقی ها</a>
                @endforelse
            </div>
        </div>
    </div>
</div>