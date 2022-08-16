<table class="table table-striped">
    <thead>
    <tr>
        <th class="text-center">#</th>
        <th class="text-center">نام</th>
        <th class="text-center">اسلاگ</th>
        <th class="text-center">کیفیت</th>
        <th class="text-center">وضعیت انتشار</th>
        <th class="text-center">آلبوم</th>
        <th class="text-center">هنرمند</th>
        <th class="text-center">ویرایش</th>
        <th class="text-center">نمایش</th>
        <th class="text-center">حذف</th>
        <th class="text-center">تاریخ انتشار</th>
        <th class="text-center">تاریخ ایجاد</th>
        <th class="text-center">ایجاد شده توسط</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($songs as $song)
        <tr class="text-center">
            <th scope="row">{{ $loop->iteration + $pageNumMultiplyPageNum }}</th>
            <td>{{ $song->name }}</td>
            <td>{{ $song->slug }}</td>
            <td>
                @if($song->songFiles->where("quality", "128")->count() != 0 &&
                         $song->songFiles->where("quality", "320")->count() != 0)
                    128 & 320
                @endif
                @if($song->songFiles->where("quality", "128")->count() != 0 &&
                            $song->songFiles->where("quality", "320")->count() == 0)
                    128
                @endif
                @if($song->songFiles->where("quality", "128")->count() == 0 &&
                            $song->songFiles->where("quality", "320")->count() != 0)
                    320
                @endif
            </td>
            <td>
                @if($song->published)
                    منتشر شده ✅
                @else
                    منتشر نشده ❌
                @endif
            </td>
            <td>
                @if($song->album)
                    <a href="{{ route('albums.show', $song->album->slug) }}">{{ $song->album->name }}</a>
                @else
                    ندارد
                @endif
            </td>
            <td>{{$song->artist->name }}</td>
            <td>
                <a class="btn btn-warning" href="{{ route('songs.edit', $song->slug) }}">ویرایش</a>
            </td>
            <td>
                <a class="btn btn-primary" href="{{ route('songs.show', $song->slug) }}">مشاهده</a>
            </td>
            <td>
                <form action="{{ route('songs.destroy', $song->slug) }}" method="POST">
                    @csrf
                    @method('delete')
                    <input type="submit" value="حذف" class="btn btn-danger">
                </form>
            </td>
            <td>
                {{(new Carbon\Carbon($song->publish_date))->diffForHumans(now())}} الان
            </td>
            <td>{{ $song->created_at->format('Y-m-d') }}</td>
            <td>{{ $song->user->name }}</td>
        </tr>
    @empty
        <tr>
            <th>موسیقی ای پیدا نشد!</th>
        </tr>
    @endforelse
    </tbody>
</table>

{{ $songs->links() }}
