<!-- Hero block area -->
<div id="latestalbum" class="hero pad">
    <div class="container">
        <!-- hero content -->
        <div class="hero-content ">
            <!-- heading -->
            <h2>جدیدترین آلبوم ها</h2>
            <hr>
            <!-- paragraph -->
            <p>We sing the best <strong class="theme-color">Songs</strong> and now we control the world best <strong class="theme-color">Music</strong>.</p>
        </div>
        @forelse($latestAlbums as $album)
            <!-- hero play list -->
            <div class="hero-playlist">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <!-- music album image -->
                        <div class="figure">
                            <!-- image -->
                            {{-- <img class="img-responsive" src="img/album/1.jpg" alt="" /> --}}
                            <img class="img-responsive" src="{{ $album->image ? $album->image->url() : asset('img/user/1.jpg') }}" alt="" />
                            <!-- disk image -->
                            <img class="img-responsive disk" src="img/album/disk.png" alt="" />
                        </div>
                        <!-- album details -->
                        <div class="album-details">
                            <!-- title -->
                            <h4>{{ $album->name }}</h4>
                            <!-- composed by -->
                            <h5>By {{ $album->artist->name }}</h5>
                            <!-- paragraph -->
                            @foreach ($album->tags as $tag)
                                <a class="badge bg-success" href="{{ route('front.tags', $tag->slug) }}">{{ $tag->name }}</a>
                            @endforeach
                            <br>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <!-- play list -->
                        <div class="playlist-content">
                            <ul class="list-unstyled">
                                @forelse($album->songs as $song)
                                    <li class="playlist-number">
                                        <!-- song information -->
                                        <div class="song-info">
                                            <audio controls>
                                                <source src="{{ $song->songFiles->where("quality", 128)->count() != 0 ? Storage::url($song->songFiles->where("quality", 128)->first()->path)  : '' }}" type="audio/mpeg">
                                                  Your browser does not support the audio element.
                                              </audio> 
                                            <!-- song title -->
                                            <h4>{{ $song->name }}</h4>
                                            <p><strong>Album</strong>: {{$album->name}} &nbsp;|&nbsp; <strong>Artist</strong>: {{$album->artist->name }}</p>
                                        </div>
                                        <div class="clearfix"></div>



                                    </li>
                                @empty
                                    موسیقی در این آلبوم وجود ندارد!
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-6 col-sm-6">
                آلبومی در حال حاضر وجود ندارد!
            </div>
        @endforelse
        <h3><a href="{{ route('front.albums') }}">مشاهده بیشتر</a></h3>
    </div>
</div>
<!--/ hero end -->
