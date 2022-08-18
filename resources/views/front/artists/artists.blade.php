@extends('front.layouts.index')

@section('content')
    <div class="featured pad" id="">
        <div class="container">
            <!-- default heading -->
            <div class="default-heading">
                <!-- heading -->
                <h2>هنرمندان</h2>
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
                                        <img class="img-responsive" src="{{ $artist->image ? $artist->image->url() : asset('img/user/1.jpg') }}" alt="Song's cover" />
                                    </a>
                                </div>
                                <div class="hero-playlist">
                                    <div class="album-details">
                                        <!-- title -->
                                        <a href="{{ route('show.artist', $artist->slug) }}" class="text-decoration-none">
                                            <h4>{{ $artist->name }}</h4>
                                        </a>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>          
                    @empty
                        هنرمندی در حال حاضر وجود ندارد!
                    @endforelse
                </div>  
            </div>
            {{$artists->links()}}
        </div>
    </div>

@endsection