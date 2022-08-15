@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class=""><a href="{{ route('admin.home') }}">خانه</a></li>
                    <li class="" aria-current="page">لیست ژانر ها</li>
                </ol>
            </nav>

            @include('messages')
            <div class="row">
                <div class="col-md-4">
                    <a class="btn btn-primary w-25" href="{{ route("tags.create") }}">ایجاد ژانر</a>
                </div>
                <div class="col-md-8">
                    <form>
                        <div>
                            <div class="row">
                                <div class="col-md-8"><input class="form-control" type="search" name="search"
                                    placeholder="نام ژانر را جستجو کنید..."></div>
                                <div class="col-md-4"><button class="btn btn-secondary">جستجو</button></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @include('tags.table')
    </div>


@endsection
