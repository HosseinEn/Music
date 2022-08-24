<!-- header area -->
<header>
    <!-- secondary menu -->
    <nav class="secondary-menu">
        <div class="container">
            <!-- secondary menu left link area -->
            <div class="sm-left">
                <strong>Phone</strong>:&nbsp; <a href="#">555 555 555</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <strong>E-mail</strong>:&nbsp; <a href="#">music.site@melodi.com</a>
            </div>
            <!-- secondary menu right link area -->
            <div class="sm-right">
                <!-- social link -->
                <div class="sm-social-link">
                    <a class="h-facebook" href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a class="h-twitter" href="#"><i class="fa-brands fa-twitter"></i></a>
                    <a class="h-google" href="#"><i class="fa-brands fa-google-plus"></i></a>
                    <a class="h-linkedin" href="#"><i class="fa-brands fa-linkedin"></i></a>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </nav>
    <!-- primary menu -->
    <nav class="navbar navbar-fixed-top navbar-default">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- logo area -->
                <a class="navbar-brand" href="{{ route('home') }}">
                    <!-- logo image -->
                    Musics
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    @guest
                        <li class="nav-item"><a href="{{ route('login') }}">ورود</a></li>
                        <li class="nav-item"><a href="{{ route('register')  }}">ثبت نام</a></li>
                    @else
                        @if(Auth::user()->is_admin)
                            <li><a href="{{ route('admin.home') }}">{{ Auth::user()->name }}</a></li>
                        @else
                            <li>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"
                                    style="margin-top: 18px; margin-right: 5px;">
                                        {{ Auth::user()->name }}
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" style="" aria-labelledby="dropdownMenu1">
                                        <li><a style="color: black;" href="{{ route('user.favorites') }}">علاقه مندی های شما</a></li>
                                    </ul>
                                </div>
                            </li>
                        @endif
                        <li>
                            <form action="{{ route('logout') }}" method="POST" style="margin-top: 18px;">
                                @csrf
                                <input type="submit" value="خروج" class="btn btn-danger">
                            </form>
                        </li>
                    @endguest
                    <li><a href="{{ route('home') }}#search">جستجو</a></li>
                    <li><a href="{{ route('home') }}#latestalbum">آلبوم ها</a></li>
                    <li><a href="{{ route('home') }}#latestsongs">موسیقی ها</a></li>
                    <li><a href="{{ route('home') }}#genres">ژانرها</a></li>
                    <li><a href="{{ route('home') }}#artists">هنرمندان</a></li>
                    <li><a href="{{ route('home') }}#contact">ارتباط با ما</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>
<!--/ header end -->