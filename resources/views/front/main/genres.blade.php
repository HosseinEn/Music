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
            <p class="why-message">It would be a great pleasure to have you in our team, follow these steps to join us.</p>
            <div class="row">
                @forelse ($tags as $tag)
                    <a href="{{ route('front.tags', $tag->slug) }}">
                        <div class="col-md-3 col-sm-6">
                            <div class="why-item  delay-one">
                                <span class="why-number" style="font-size:34px;">{{ $tag->name }}</span>
                                <!-- paragraph -->
                                <p>Sed ut perspi ciatis unde omnis iste natus error sit vol uptatem accus antium totam rem aperiam, eaque ipsa quae ab illo inventore veritatisnatus.</p>
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
