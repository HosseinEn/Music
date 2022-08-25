@extends("front.layouts.index")

@section('title', 'نمایش براساس ژانرها')

@section("content")
    <div class="featured pad" id="">
        <div class="container">
            <!-- default heading -->
            <div class="default-heading">
                <!-- heading -->
                <h2>موسیقی ها و آلبوم ها در ژانر 
                    <select class="" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                        @foreach($tags as $tagItem)
                            <option value="{{ route('front.tags', $tagItem->slug) }}" {{ $tagItem->slug == $tag->slug ? 'selected' : '' }}>{{ $tagItem->name }}</option>
                        @endforeach
                    </select> 
                </h2>


                <form action="" method="GET">
                    <label for="show">نمایش بر حسب:</label>
                    <select name="show" id="" id="show">
                        <option value="songs"  {{ Request::get("show") == "songs" ? 'selected' : '' }}>موسیقی ها</option>
                        <option value="albums" {{ Request::get("show") == "albums" ? 'selected' : '' }}>آلبوم ها</option>
                    </select>

                    <button type="submit" class="btn btn-success">نمایش</button>
                </form>

            </div>
            <!-- featured album elements -->
            <div class="featured-element">
                <div class="row">
                    @forelse ($items as $item)
                        <div class="col-md-3 col-sm-6">
                            <!-- featured item -->
                            <div class="featured-item ">
                                <!-- image container -->
                                <div class="figure">
                                    <!-- image -->
                                    @if(get_class($item) === "App\Models\Album")
                                        <a href="{{ route('show.album', $item->slug) }}" class="text-decoration-none">
                                    @else
                                        <a href="{{ route('show.song', $item->slug) }}" class="text-decoration-none">
                                    @endif
                                        <img class="img-responsive" style="" src="{{  $item->image ? $item->image->url() : asset('img/user/1.jpg')  }}" alt="Song's cover" />
                                    </a>
                                    <!-- paragraph -->
                                    @foreach ($item->tags as $tag)
                                        <a class="badge bg-success" href="{{ route('front.tags', $tag->slug) }}">{{ $tag->name }}</a>
                                    @endforeach
                                </div>
                                <div class="hero-playlist">
                                    <div class="album-details">
                                        @if(get_class($item) === "App\Models\Album")
                                            <a href="{{ route('show.album', $item->slug) }}" class="text-decoration-none">
                                        @else
                                            <a href="{{ route('show.song', $item->slug) }}" class="text-decoration-none">
                                        @endif
                                            <h4>{{ $item->name }}</h4>
                                            <h5>{{ $item->artist->name }}</h5>
                                        </a>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>          
                    @empty
                        آهنگ یا آلبومی در حال حاضر وجود ندارد!
                    @endforelse
                </div>
                {{ $items->appends($_GET)->links() }}
            </div>
        </div>
    </div>
@endsection