@extends('layouts.app')

@section('title', 'مدیریت موسیقی ها')

@section('content')
    <div class="container">
        <div class="row">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class=""><a href="{{ route('admin.home') }}">خانه</a></li>
                    <li class="" aria-current="page">لیست موسیقی ها</li>
                </ol>
            </nav>

            @include('messages')
            <div class="row">
                <div class="col-md-4">
                    <a class="btn btn-primary w-50" href="{{ route('songs.create') }}">ایجاد موسیقی</a>
                </div>
                <div class="col-md-8">
                    <form>
                        <div>
                            <div class="row">
                                <div class="col-md-8">
                                    <input class="form-control" type="search" name="search" 
                                    placeholder="نام موسیقی، آلبوم یا هنرمند را جستجو کنید...">
                                </div>
                                <div class="col-md-4"><button class="btn btn-secondary">جستجو</button></div>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>
            <p class="mt-3">موسیقی هایی که عضو آلبوم هستند، در صورت فعال بودن انتشار خودکار برای آلبوم، موسیقی های مرتبط با آن نیز در زمان تعیین شده منتشر خواهند شد.</p>
            @include('songs.table')
        </div>
    </div>


@endsection
