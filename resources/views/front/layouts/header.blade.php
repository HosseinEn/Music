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
                    <a class="h-facebook" href="#"><i class="fa fa-facebook"></i></a>
                    <a class="h-twitter" href="#"><i class="fa fa-twitter"></i></a>
                    <a class="h-google" href="#"><i class="fa fa-google-plus"></i></a>
                    <a class="h-linkedin" href="#"><i class="fa fa-linkedin"></i></a>
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
                    <li><a href="{{ route('home') }}#search">جستجو</a></li>
                    @guest
                        <li><a href="{{ route('login') }}">ورود</a></li>
                        <li><a href="{{ route('register')  }}">ثبت نام</a></li>
                    @else
                        @if(Auth::user()->is_admin)
                            <li><a href="{{ route('admin.home') }}">{{ Auth::user()->name }}</a></li>
                        @else
                            <li><a href="{{ route('user.favorites') }}">{{ Auth::user()->name }}</a></li>
                        @endif
                        <li>
                            <form action="{{ route('logout') }}" method="POST" style="margin-top: 18px;">
                                @csrf
                                <input type="submit" value="خروج" class="btn btn-danger">
                            </form>
                        </li>
                    @endguest
                    <li><a href="{{ route('home') }}#latestalbum" style="font-size: 12px;">جدیدترین آلبوم ها</a></li>
                    <li><a href="{{ route('home') }}#latestsongs" style="font-size: 12px;">جدیدترین موسیقی ها</a></li>
                    <li><a href="{{ route('home') }}#genres">ژانرها</a></li>
                    <li><a href="{{ route('home') }}#events">رویداد ها</a></li>
                    <li><a href="{{ route('home') }}#artists">هنرمندان</a></li>
                    <li><a href="{{ route('home') }}#contact">ارتباط با ما</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>
<!--/ header end -->