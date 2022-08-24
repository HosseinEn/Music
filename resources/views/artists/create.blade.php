@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="{{ route('admin.home') }}">خانه</a></li>
                    <li><a href="{{ route('artists.index') }}">لیست هنرمندان</a></li>
                    <li>ایجاد هنرمند جدید</li>
                </ol>
            </nav>

            <form class="bg-dark text-white" action="{{ route('artists.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">نام هنرمند:</label>
                    <input type="text" id="name" name="name"
                           class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}">
                    <span class="invalid-feedback" role="alert">
                        @error('name')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                </div>
                <div class="form-group">
                    <label for="slug">slug:</label>
                    <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror"
                           value="{{old('slug')}}">
                    <small>در صورت خالی گذاشتن این فیلد، به صورت خودکار نام هنرمند به اسلاگ تبدیل خواهد شد</small>
                    <span class="invalid-feedback" role="alert">
                        @error('slug')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                </div>
                <div class="form-group">
                    <label for="file">انتخاب تصویر:</label>
                    <input type="file" name="image" class="form-control  @error('image') is-invalid @enderror" id="file"
                           value="{{old('image')}}">
                    <span class="invalid-feedback" role="alert">
                        @error('image')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">ایجاد</button>
                </div>
            </form>
        </div>
    </div>
@endsection
