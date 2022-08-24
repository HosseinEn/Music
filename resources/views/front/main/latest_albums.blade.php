<!-- Hero block area -->
<div id="latestalbum" class="hero pad">
    <div class="container">
        <!-- hero content -->
        <div class="hero-content ">
            <!-- heading -->
            <h2>جدیدترین آلبوم ها</h2>
            <hr>
            <!-- paragraph -->
            <p>جدیدترین آلبوم هایی که <strong class="theme-color">اخیرا</strong> منتشر شده اند!</p>
        </div>
        @forelse($latestAlbums as $album)
            <!-- hero play list -->
            <div class="hero-playlist">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <!-- music album image -->
                        <div class="figure">
                            <!-- image -->
                            <a href="{{ route('show.album', $album->slug) }}" class="text-decoration-none">
                                <img class="img-responsive" src="{{ $album->image ? $album->image->url() : asset('img/user/1.jpg') }}" alt="" />
                                <img class="img-responsive disk" src="img/album/disk.png" alt="" />
                            </a>
                            <!-- disk image -->
                        </div>
                        <!-- album details -->
                        <a href="{{ route('show.album', $album->slug) }}" class="text-decoration-none">
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
                        </a>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <!-- play list -->
                        <div class="playlist-content">
                            <ul class="list-unstyled" style="margin: 0 auto;">
                                @forelse($album->songs->take(3) as $song)
                                    <li class="playlist-number" >
                                        <!-- song information -->
                                        <div class="song-info" >
                                            <h4><b>{{ $song->name }}</b></h4>
                                            <audio controls >
                                                <source src="{{ $song->songFiles->where("quality", 128)->count() != 0 ? Storage::url($song->songFiles->where("quality", 128)->first()->path)  
                                                                                                                      : Storage::url($song->songFiles->where("quality", 320)->first()->path) }}" type="audio/mpeg">
                                                  Your browser does not support the audio element.
                                            </audio> 
                                            <!-- song title -->
                                            <p>
                                                <strong>Album</strong>: {{$album->name}} &nbsp;|&nbsp; <strong>Artist</strong>: 
                                                {{ $album->artist->name == $song->artist->name ? $album->artist->name : $album->artist->name . ' Feat ' . $song->artist->name }}
                                            </p>
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
        <h3><a class="btn btn-primary btn-lg" href="{{ route('front.albums') }}?order=released">مشاهده بیشتر >></a></h3>
    </div>
</div>
<!--/ hero end -->
