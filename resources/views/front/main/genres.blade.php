<!-- work with us -->
<div class="work-with-us pad" id="genres">
    <div class="container">
        <!-- default heading -->
        <div class="default-heading">
            <!-- heading -->
            <h2>ژانر ها در هر حس و حال</h2>
        </div>
        <div class="why-content">
            <!-- paragraph -->
            <div class="hero-content">
                <p>موسیقی ها و آلبوم های موجود در هر ژانر را بیابید!</p>
            </div>
            <div class="row" style="text-align: center;">
                @forelse ($tags as $tag)
                    <a href="{{ route('front.tags', $tag->slug) }}">
                        <div class="col-md-3 col-sm-6">
                            <div class="why-item  delay-one">
                                <span class="why-number" style="font-size:34px;">{{ $tag->name }}</span>
                            </div>
                        </div>
                    </a>
                @empty
                    ژانری در حال حاضر وجود ندارد!
                @endforelse
            </div>
        </div>
    </div>
</div>
<!--/ end work with us -->
