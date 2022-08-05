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

            <a class="btn btn-primary w-25" href="{{ route('artists.create') }}">ایجاد هنرمند</a>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">نام</th>
                    <th class="text-center">اسلاگ</th>
                    <th class="text-center">ویرایش</th>
                    <th class="text-center">نمایش</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($artists as $artist)
                    <tr class="text-center">
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $artist->name }}</td>
                        <td>{{ $artist->slug }}</td>
                        <td>
                            <a class="btn btn-warning w-50" href="{{ route('artists.edit', $artist->slug) }}">ویرایش</a>
                        </td>
                        <td>
                            <a class="btn btn-primary w-50" href="{{ route('artists.show', $artist->slug) }}">مشاهده</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
