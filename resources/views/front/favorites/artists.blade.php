<div class="featured pad" id="">
    <div class="container">
        <!-- default heading -->
        <div class="default-heading">
            <!-- heading -->
            <h2>هنرمندان مورد علاقه شما</h2>
        </div>
        <!-- featured album elements -->
        <div class="featured-element">
            <div class="row">
                @forelse ($artists as $artist)
                    <div class="col-md-3 col-sm-6">
                        <!-- featured item -->
                        <div class="featured-item ">
                            <!-- image container -->
                            <div class="figure">
                                <!-- image -->
                                <a href="{{ route('show.artist', $artist->slug) }}" class="text-decoration-none">
                                    <img class="img-responsive" style="height: 200px;" src="{{ $artist->image ? $artist->image->url() : asset('img/user/1.jpg') }}" alt="Artists's cover" />
                                </a>
                            </div>
                            <div class="hero-playlist">
                                <div class="album-details">
                                    <a href="{{ route('show.artist', $artist->slug) }}" class="text-decoration-none">
                                        <h5>{{ $artist->name }}</h5>
                                    </a>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>          
                @empty
                    شما هنرمندی را به علاقه مندی های خود اضافه نکردید! <a href="{{ route('front.artists') }}">مشاهده هنرمندان</a>
                @endforelse
            </div>
        </div>
    </div>
</div>