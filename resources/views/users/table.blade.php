<table class="table table-striped">
    <thead>
    <tr>
        <th class="text-center">#</th>
        <th class="text-center">نام</th>
        <th class="text-center">E-mail</th>
        <th class="text-center">ویرایش</th>
        <th class="text-center">نقش</th>
        <th class="text-center">حذف</th>
        <th class="text-center">تاریخ ایجاد</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($users as $user)
        <tr class="text-center">
            <th scope="row">{{ $loop->iteration + $pageNumberMultiplyPaginationSize }}</th>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                @can('edit-admin', $user)
                    <a class="btn btn-warning" href="{{ route('users.edit', $user->id) }}">ویرایش</a>
                @endcan
            </td>
            <td>
                @if($user->is_admin)
                    ادمین
                @else
                    کاربر
                @endif
            </td>
            <td>
                @can('delete-admin', $user)
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('delete')
                        <input type="submit" value="حذف" class="btn btn-danger">
                    </form>
                @endcan
            </td>
            <td>{{ $user->created_at->format('Y-m-d') }}</td>
        </tr>
    @empty
        <tr>
            <th>کاربری پیدا نشد!</th>
        </tr>
    @endforelse
    </tbody>
</table>

{{ $users->links() }}
