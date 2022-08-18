<table class="table table-striped">
    <thead>
    <tr>
        <th class="text-center">#</th>
        <th class="text-center">نام</th>
        <th class="text-center">اسلاگ</th>
        <th class="text-center">ویرایش</th>
        <th class="text-center">نمایش</th>
        <th class="text-center">حذف</th>
        <th class="text-center">تاریخ ایجاد</th>
        <th class="text-center">ایجاد شده توسط</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($artists as $artist)
        <tr class="text-center">
            <th scope="row">{{ $loop->iteration + $pageNumberMultiplyPaginationSize }}</th>
            <td>{{ $artist->name }}</td>
            <td>{{ $artist->slug }}</td>
            <td>
                <a class="btn btn-warning" href="{{ route('artists.edit', $artist->slug) }}">ویرایش</a>
            </td>
            <td>
                <a class="btn btn-primary" href="{{ route('artists.show', $artist->slug) }}">مشاهده</a>
            </td>
            <td>
                <form action="{{ route('artists.destroy', $artist->slug) }}" method="POST">
                    @csrf
                    @method('delete')
                    <input type="submit" value="حذف" class="btn btn-danger">
                </form>
            </td>
            <td>{{ $artist->created_at->format('Y-m-d') }}</td>
            <td>{{ $artist->user->name }}</td>
        </tr>
    @empty
        <tr>
            <th>هنرمندی پیدا نشد!</th>
        </tr>
    @endforelse
    </tbody>
</table>

{{ $artists->links() }}
