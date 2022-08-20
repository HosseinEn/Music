
<div class="about" id="artists">
    <div class="container">
        <!-- default heading -->
        <div class="default-heading">
            <!-- heading -->
            <h2>هنرمندان</h2>
        </div>
        <!-- about what we are like content -->
        {{-- <div class="about-what-we">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <div class="what-we-item ">
                        <!-- heading with icon -->
                        <h3><i class="fa fa-heartbeat"></i> What we do?</h3>
                        <!-- paragraph -->
                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit occaecat cupidatat non id est laborum.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="what-we-item ">
                        <!-- heading with icon -->
                        <h3><i class="fa fa-hand-o-up"></i> Why choose us?</h3>
                        <!-- paragraph -->
                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit occaecat cupidatat non id est laborum.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="what-we-item ">
                        <!-- heading with icon -->
                        <h3><i class="fa fa-map-marker"></i> Where we are?</h3>
                        <!-- paragraph -->
                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit occaecat cupidatat non id est laborum.</p>
                    </div>
                </div>
            </div>
        </div> --}}
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
                                        <a href="#"><i class="fa fa-facebook"></i></a>
                                        <a href="#"><i class="fa fa-google-plus"></i></a>
                                        <a href="#"><i class="fa fa-linkedin"></i></a>
                                        <a href="#"><i class="fa fa-twitter"></i></a>
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
                <h3><a href="{{ route('front.artists') }}">مشاهده بیشتر</a></h3>
            </div>
        </div>
    </div>
</div>
