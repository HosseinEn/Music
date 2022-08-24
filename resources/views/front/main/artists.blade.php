
<div class="about" id="artists">
    <div class="container">
        <!-- default heading -->
        <div class="default-heading">
            <!-- heading -->
            <h2>هنرمندان</h2>
        </div>

    </div>

    <div class="team">
        <div class="container">
 
            <div class="team-content">
                <div class="row">
                    @forelse ($artists as $artist)
                        <div class="col-md-3 col-sm-6">
                            <div class="team-member  delay-one">
                                <!-- Image Hover Block -->
                                <div class="member-img">
                                    <!-- Image  --> 
                                    <a href="{{ route('show.artist', $artist->slug) }}" class="text-decoration-none">
                                        <img class="img-responsive" style="height: 250px;" src="{{ $artist->image ? $artist->image->url() : asset('img/user/1.jpg') }}" alt="" />
                                    </a>
                                    <!-- Hover block -->
                                    <div class="social text-center">
                                        <a href="#"><i class="fa-brands fa-facebook"></i></a>
                                        <a href="#"><i class="fa-brands fa-google-plus"></i></a>
                                        <a href="#"><i class="fa-brands fa-linkedin"></i></a>
                                        <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                    </div>
                                </div>
                                <a href="{{ route('show.artist', $artist->slug) }}" class="text-decoration-none">
                                    <!-- Member Details -->
                                    <h3>{{$artist->name}}</h3>
                                </a>
                            </div>
                        </div>             
                    @empty
                        هنرمندی در حال حاضر وجود ندارد!
                    @endforelse
                </div>
                <h3><a class="btn btn-primary btn-lg" href="{{ route('front.artists') }}">مشاهده بیشتر >></a></h3>
            </div>
        </div>
    </div>
</div>
