@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class=""><a href="{{ route('admin.home') }}">خانه</a></li>
                    <li class="" aria-current="page">لیست هنرمندان</li>
                </ol>
            </nav>

            @include('messages')
            <div class="row">
                <div class="col-md-4">
                    <a class="btn btn-primary w-25" href="{{ route('artists.create') }}">ایجاد هنرمند</a>
                </div>
                <div class="col-md-8">
                    <form>
                        <div>
                            <div class="row">
                                <div class="col-md-8"><input class="form-control" type="search" name="search"></div>
                                <div class="col-md-4"><button class="btn btn-secondary">جستجو</button></div>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">نام</th>
                    <th class="text-center">اسلاگ</th>
                    <th class="text-center">ویرایش</th>
                    <th class="text-center">نمایش</th>
                    <th class="text-center">حذف</th>
                    <th class="text-center">تاریخ عضویت</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($artists as $artist)
                    <tr class="text-center">
                        <th scope="row">{{ $loop->iteration + $pageNumMultPageNum }}</th>
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
                    </tr>
                @empty
                    <tr>
                        <th>هنرمندی پیدا نشد!</th>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{ $artists->links() }}
        </div>
    </div>
@endsection
