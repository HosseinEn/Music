@extends('main.index')

@section('content')
    <div class="featured pad" id="">
        <div class="container">
            <!-- default heading -->
            <div class="default-heading">
                <!-- heading -->
                <h2>آلبوم ها</h2>
            </div>
            <!-- featured album elements -->
            <div class="featured-element">
                <div class="row">
                    @forelse ($albums as $album)
                        <div class="col-md-3 col-sm-6">
                            <!-- featured item -->
                            <div class="featured-item ">
                                <!-- image container -->
                                <div class="figure">
                                    <!-- image -->
                                    <img class="img-responsive" src="{{ $album->image ? $album->image->url() : asset('img/user/1.jpg') }}" alt="Song's cover" />
                                    <!-- paragraph -->
                                    <p>
                                        @foreach ($album->tags as $tag)
                                            <a class="badge bg-success">{{ $tag->name }}</a>
                                        @endforeach
                                    </p>
                                </div>
                                <div class="hero-playlist">
                                    <div class="album-details">
                                        <!-- title -->
                                        <h4>{{ $album->name }}</h4>
                                        <!-- composed by -->
                                        <h5>{{ $album->artist->name }}</h5>
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
            </div>
            {{$albums->links()}}
        </div>
    </div>

@endsection