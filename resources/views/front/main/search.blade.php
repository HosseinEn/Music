<div class="container" style="margin-top: 100px;" dir="ltr" id="search">
    <h2 class="text-center" style="margin-bottom: 50px;">!جستجو کنید</h2>
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-md-12">
            <div class="search">
                <form action="{{ route('search') }}" method="GET">
                    <i class="fa fa-search"></i>
                    <input type="search" name="query" class="form-control" placeholder="Search a song, album, artist...">
                    <button class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
    </div>
</div>
