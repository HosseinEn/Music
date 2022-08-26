<!-- call to action -->
@if($comingSoonSong)
    <div class="cta parallax-one pad">
        <div class="container">
            <!-- cta element -->
            <div class="cta-element ">
                <div class="row">
                    <div class="col-md-9 col-sm-8">
                        <!-- heading -->
                        <h3>{{ $comingSoonSong->name }}</h3>
                        <!-- paragraph -->
                        <p>انتشار به زودی...</p>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="cta-btn text-center">
                            <!-- purchase now button -->
                            <a href="#" class="btn btn-default btn-lg">{{ (new Carbon\Carbon($comingSoonSong->publish_date))->diffForHumans(now()) }} الان</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
<!--/ cta end -->
