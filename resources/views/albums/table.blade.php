<table class="table table-striped">
    <thead>
    <tr>
        <th class="text-center">#</th>
        <th class="text-center">نام</th>
        <th class="text-center">اسلاگ</th>
        <th class="text-center">هنرمند</th>
        <th class="text-center">ویرایش</th>
        <th class="text-center">نمایش</th>
        <th class="text-center">حذف</th>
        <th class="text-center">تاریخ ایجاد</th>
        <th class="text-center">ایجاد شده توسط</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($albums as $album)
        <tr class="text-center">
            <th scope="row">{{ $loop->iteration + $pageNumMultiplyPageNum }}</th>
            <td>{{ $album->name }}</td>
            <td>{{ $album->slug }}</td>
            <td>{{ $album->artist->name }}</td>
            <td>
                <a class="btn btn-warning" href="{{ route('albums.edit', $album->slug) }}">ویرایش</a>
            </td>
            <td>
                <a class="btn btn-primary" href="#">مشاهده</a>
            </td>
            <td>
                <form action="{{ route('albums.destroy', $album->slug) }}" method="POST">
                    @csrf
                    @method('delete')
                    <input type="submit" value="حذف" class="btn btn-danger">
                </form>
            </td>
            <td>{{ $album->created_at->format('Y-m-d') }}</td>
            <td>{{ $album->user->name }}</td>
        </tr>
    @empty
        <tr>
            <th>آلبومی پیدا نشد!</th>
        </tr>
    @endforelse
    </tbody>
</table>

{{ $albums->links() }}
