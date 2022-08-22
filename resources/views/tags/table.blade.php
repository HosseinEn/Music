<table class="table table-striped mt-3" style="border-color: black;" border="1px;">
    <thead>
    <tr>
        <th class="text-center">#</th>
        <th class="text-center">نام</th>
        <th class="text-center">اسلاگ</th>
        <th class="text-center">ویرایش</th>
        <th class="text-center">حذف</th>
        <th class="text-center">تاریخ ایجاد</th>
        <th class="text-center">ایجاد شده توسط</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($tags as $tag)
        <tr class="text-center">
            <th scope="row">{{ $loop->iteration + $pageNumberMultiplyPaginationSize }}</th>
            <td>{{ $tag->name }}</td>
            <td>{{ $tag->slug }}</td>
            <td>
                <a class="btn btn-warning" href="{{ route('tags.edit', $tag->slug) }}">ویرایش</a>
            </td>
            <td>
                <form action="{{ route('tags.destroy', $tag->slug) }}" method="POST">
                    @csrf
                    @method('delete')
                    <input type="submit" value="حذف" class="btn btn-danger">
                </form>
            </td>
            <td>{{ $tag->created_at->format('Y-m-d') }}</td>
            <td>{{ $tag->user->name }}</td>
        </tr>
    @empty
        <tr>
            <th>ژانری پیدا نشد!</th>
        </tr>
    @endforelse
    </tbody>
</table>

{{ $tags->links() }}
