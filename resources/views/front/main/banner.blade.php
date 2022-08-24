<!-- banner area -->
<div class="banner">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            @forelse($banner as $song)
                <div class="item {{ $loop->first ? 'active' : '' }} ">
                    <img style="" src="{{ asset('img/banner/b1.jpg') }}" alt="{{ $song->name }}">
                    <div class="container">
                        <!-- banner caption -->
                        <div class="carousel-caption slide-one">
                            <!-- heading -->
                            <h2 class="animated fadeInLeftBig"><i class="fa fa-music"></i>{{ $song->name }}</h2>
                            <h4 class="animated fadeInLeftBig">{{ $song->artist->name }}</h4>
                            <!-- paragraph -->
                            <h3 class="animated fadeInRightBig">هر موسیقی را که می خواهید اینجا پیدا کنید!</h3>
                            <!-- button -->
                            <a href="{{ route('show.song', $song->slug) }}" class="animated fadeIn btn btn-theme">گوش دهید</a>
                        </div>
                    </div>
                </div>
            @empty
                موسیقی ای در حال حاضر موجود نیست!
            @endforelse
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="fa fa-arrow-left" aria-hidden="true"></span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="fa fa-arrow-right" aria-hidden="true"></span>
        </a>
    </div>
</div>
<!--/ banner end -->
