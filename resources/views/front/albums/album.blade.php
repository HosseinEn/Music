<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fondamento&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
        integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/audioplayer.css') }}">
    <title>{{ $album->name }}</title>
</head>

<body style="">
    @forelse($album->songs as $song)
        <div class="bg-image"
            style="background-image:linear-gradient(rgba(254, 4, 4, 0.527),rgba(102, 100, 100, 0.5)),
                url('{{ $song->image ? $song->image->url() : asset('img/user/1.jpg') }}');">
            <a class="btn btn-primary" style="float: right;" href="{{ route('home') }}">Home</a>
            <ul class="list-group" style="position : absolute;  width:400px;">
                @foreach ($album->songs as $songQuickAccess)
                    <a class="text-dark" style="font-size: 20px; text-decoration: none;"
                        name="{{ $songQuickAccess->slug }}" href="#{{ $songQuickAccess->slug }}">
                        <li class="list-group-item" name="{{ $songQuickAccess->slug }}">
                            {{ $songQuickAccess->name }}
                        </li>
                    </a>
                @endforeach
            </ul>
            <div class="container" id="{{ $song->slug }}">
                <div class="row text-center">
                    @if($loop->first)
                        <h3 class="text-light mt-3">Album: {{ $album->name }}</h3>
                        @auth
                            @if($album->userLiked())
                                <form action="{{ route('user.removed.liked.album', $album->slug) }}" id="remove_like_form" method="POST">
                                    @csrf
                                </form>
                                <i onclick="document.querySelector('#remove_like_form').submit()"
                                    class="fa fa-bookmark" style="font-size: 30px; cursor: pointer;"></i>
                            @else
                                <form action="{{ route('user.liked.album', $album->slug) }}" id="like_form" method="POST">
                                    @csrf
                                </form>
                                <i onclick="document.querySelector('#like_form').submit()" 
                                    class="far fa-bookmark" style="font-size: 30px; cursor: pointer;"></i><p class="text-dark">Save Album!</p>
                            @endif
                        @else
                            <h3 class="text-center" 
                                style="line-height: 50px; border-radius: 10px;">
                                !<a href="{{ route('register') }}">ثبت نام</a> کنید و این آلبوم را به علاقه مندی های خود اضافه کنید</h3>
                        @endguest
                    @endif  
                    <div class="col-md-12" style="margin-top: 20px; ">
                        <h1 class="text-white" style="font-size: 70px;">{{ $song->name }}</h1>
                        <p class="text-white mb-0">
                            {{ $album->artist->name == $song->artist->name 
                                ? $album->artist->name 
                                : $album->artist->name . ' Feat ' . $song->artist->name }}
                        </p>
                        <small class="text-white">{{ $album->released_date }}</small>
                        <br>
                        <audio controls style="margin-top: 200px;">
                            <source src="{{ $song->songFiles->where("quality", 128)->count() != 0 
                                ? Storage::url($song->songFiles->where("quality", 128)->first()->path)  
                                : Storage::url($song->songFiles->where("quality", 320)->first()->path) }}" type="audio/mpeg">
                              Your browser does not support the audio element.
                        </audio> 
                        @auth
                            @if($song->userLiked())
                                <form action="{{ route('user.removed.liked.song', $song->slug) }}" id="remove_song{{$song->id}}_like_form" method="POST">
                                    @csrf
                                </form>
                                <i onclick="document.querySelector('#remove_song{{$song->id}}_like_form').submit()"
                                    class="fa fa-bookmark" style="font-size: 30px; cursor: pointer;"></i><p class="text-dark">Save this song!</p>
                            @else
                                <form action="{{ route('user.liked.song', $song->slug) }}" id="song{{$song->id}}_like_form" method="POST">
                                    @csrf
                                </form>
                                <i onclick="document.querySelector('#song{{$song->id}}_like_form').submit()" 
                                    class="far fa-bookmark" style="font-size: 30px; cursor: pointer;"></i><p class="text-dark">Save this song!</p>
                            @endif
                        @else
                            <h5 class="text-center" 
                                style="border-radius: 10px;">
                            !<a href="{{ route('register') }}">ثبت نام</a> کنید و این موسیقی را به علاقه مندی های خود اضافه کنید</h5>
                        @endguest
                        {{-- <audio
                            src="{{ $song->songFiles->where('quality', 128)->count() != 0
                                ? Storage::url($song->songFiles->where('quality', 128)->first()->path)
                                : Storage::url($song->songFiles->where('quality', 320)->first()->path) }}"
                            id="songPlayer">
                        </audio> --}}
                        {{-- <div class="audio-container">
                            <div class="circle-wrap">
                                <div class="circle">
                                    <div class="mask full animationEffect">
                                        <div class="fill animationEffect"></div>
                                    </div>
                                    <div class="mask half">
                                        <div class="fill animationEffect"></div>
                                    </div>
                                </div>
                                <div class="inside-circle" style="background-image: url('{{ $song->image->url() }}')"
                                    id="inside-circle"></div>
                                <div class="button-circle" id="buttonCircle">
                                    <a id="play-pause-button" class="fa fa-play text-decoration-none"></a>
                                </div>

                            </div>
                            <div class="inputCont">
                                <input style="" type="range" min="0" max="0" id="seekbar">
                                <section style="margin-left: 10px;" id="currentTimeShown"></section>/
                                <section style="" id="TimeShown"></section>
                            </div>
                            <br>
                            Music Player by<a href="https://github.com/Arash-Seifi"
                                class="text-white text-decoration-none"> Arash Seifi</a>
                        </div> --}}

                        <br>
                        <div class="">
                            @if ($song->songFiles->where("quality", 128)->count() != 0 )
                                <a href="{{ route('download.song', $song->slug) }}?quality=128"
                                    class="btn btn-secondary">Download 128kbps</a><br>
                            @endif
                            @if ($song->songFiles->where("quality", 320)->count() != 0 )
                                <a href="{{ route('download.song', $song->slug) }}?quality=320"
                                    class="btn btn-secondary mt-1">Download 320kbps</a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @empty
        موسیقی در این آلبوم وجود ندارد!
    @endforelse
    <script src="{{ asset('js/audioplayer.js') }}"></script>
    <script>
        const onClick = (event) => {
            if (event.target.nodeName === 'LI') {
                const activeElements = document.querySelectorAll('.active');
                activeElements.forEach(function(element) {
                    element.classList.remove("active");
                });

                var hashName = event.target.attributes.name.value;
                document.getElementsByName(hashName).forEach(function(element) {
                    if (element.nodeName === "LI") {
                        element.classList.add("active");
                    }
                });
            }
        }
        window.addEventListener('click', onClick)
    </script>
</body>

</html>
