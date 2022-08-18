<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        .textParent {
            /* backdrop-filter: invert(80%); */
        }
        .bg-image {
            position: relative;
            background-size: cover;
            height: 900px !important;
        }
        .bg-image:after {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            opacity: 0.5;
            background-repeat: no-repeat;
            /* background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('http://placehold.it/350x150'); */
        }
    </style>
    </head>
    <body style="">
        @forelse($album->songs as $song)
            <div class="bg-image"   
                    style="background-image:linear-gradient(rgba(254, 4, 4, 0.527),rgba(102, 100, 100, 0.5)), url('{{ $song->image->url() }}');">
                <a class="btn btn-primary" style="float: right;" href="{{ route('home') }}">Home</a>
                <ul class="list-group" style="position : absolute;  width:400px;">
                    @foreach($album->songs as $songQuickAccess)
                        <a class="text-dark" style="font-size: 20px; text-decoration: none;" name="{{$songQuickAccess->slug}}" href="#{{ $songQuickAccess->slug }}">
                            <li class="list-group-item" name="{{$songQuickAccess->slug}}">
                                {{ $songQuickAccess->name }}
                            </li>
                        </a>
                    @endforeach
                </ul>
                <div class="container" id="{{$song->slug}}">
                    <div class="row text-center">
                        <h3 class="text-light mt-3">Album: {{ $album->name }}</h3>
                        <div class="col-md-12 textParent" style="margin-top: 200px; ">
                            <h1 class="text-white" style="font-size: 100px;">{{ $song->name }}</h1>
                            <p class="text-white mb-0">{{ $album->artist->name }}</p>
                            <small  class="text-white">{{ $album->released_date }}</small>
                            <br>
                            <audio controls style="margin-top: 200px;">
                                <source src="{{ $song->songFiles->where("quality", 128)->count() != 0 ? Storage::url($song->songFiles->where("quality", 128)->first()->path)  : Storage::url($song->songFiles->where("quality", 320)->first()->path) }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio> 
                            <br>
                            <div class="mt-4">
                                @if($song->songFiles()->quality128Exists())
                                    <a href="{{ route('download.song', $song->slug) }}?quality=128" class="btn btn-secondary" >Download 128kbps</a><br>
                                @endif
                                @if($song->songFiles()->quality320Exists())
                                    <a href="{{ route('download.song', $song->slug) }}?quality=320" class="btn btn-secondary mt-2">Download 320kbps</a>
                                @endif
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        @empty
            موسیقی در این آلبوم وجود ندارد!
        @endforelse
        <script>
            const onClick = (event) => {
                if (event.target.nodeName === 'LI') {
                    const activeElements = document.querySelectorAll('.active');
                    activeElements.forEach(function(element) {
                        element.classList.remove("active");
                    });

                    var hashName = event.target.attributes.name.value;
                    document.getElementsByName(hashName).forEach(function(element) {
                        if(element.nodeName === "LI") {
                            element.classList.add("active");
                        }
                    });
                }
            }
            window.addEventListener('click', onClick)
        </script>
        {{-- <div class="bg-image"   
            style="background-image:linear-gradient(rgba(254, 4, 4, 0.527),rgba(102, 100, 100, 0.5)), url('{{ $song->image->url() }}');">
            <div class="container">
                <div class="row text-center"  >
                    <div class="col-md-12 textParent" style="margin-top: 200px; ">
                        <h1 class="text-white">{{ $song->name }}</h1>
                        <p class="text-white mb-0">{{ $song->artist->name }}</p>
                        <small>{{ $song->released_date }}</small>
                        <br>
                        <audio controls style="margin-top: 200px;">
                            <source src="{{ $song->songFiles->where("quality", 128)->count() != 0 ? Storage::url($song->songFiles->where("quality", 128)->first()->path)  : '' }}" type="audio/mpeg">
                              Your browser does not support the audio element.
                          </audio> 
                        <br>
                        <div class="mt-4">
                            @if($song->songFiles()->quality128Exists())
                                <a href="{{ route('download.song', $song->slug) }}?quality=128" class="btn btn-secondary" >Download 128kbps</a><br>
                            @endif
                            @if($song->songFiles()->quality320Exists())
                                <a href="{{ route('download.song', $song->slug) }}?quality=320" class="btn btn-secondary mt-2">Download 320kbps</a>
                            @endif
                        </div>
                    </div>
                    
                </div>
            </div>
        </div> --}}
    </body>
</html>
