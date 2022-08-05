@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="{{ route('admin.home') }}">خانه</a></li>
                    <li><a href="{{ route('artists.index') }}">لیست هنرمندان</a></li>
                    <li>ویرایش اطلاعات {{ $artist->name }}</li>
                </ol>
            </nav>

            @include('messages')


            <form action="{{ route('artists.update', $artist->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="name">نام هنرمند:</label>
                    <input type="text" id="name" name="name"
                           class="form-control @error('name') is-invalid @enderror" value="{{ $artist->name }}">
                    <span class="invalid-feedback" role="alert">
                        @error('name')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                </div>
                <div class="form-group">
                    <label for="slug">slug:</label>
                    <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ $artist->slug }}">
                    <span class="invalid-feedback" role="alert">
                        @error('slug')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                    برحسب نام خودکار بروزرسانی شود.
                    <input type="checkbox" name="slug_based_on_name">
                </div>
                <div class="form-group">
                    <label for="file">انتخاب تصویر:</label>
                    <input type="file" name="image" class="form-control  @error('image') is-invalid @enderror"
                           id="file">
                    @if($artist->image)
                        <img src="{{ Storage::url($artist->image->path) }}" alt="artist_image">
                    @endif
                    <span class="invalid-feedback" role="alert">
                        @error('image')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                </div>
                <div class="form-group">
                    <a href="{{ route('artists.index') }}" class="text-decoration-none text-white">
                        <button type="button" class="btn btn-danger">
                            بازگشت
                        </button>
                    </a>
                    <button type="submit" class="btn btn-primary">ایجاد</button>
                </div>
            </form>
        </div>
    </div>
@endsection
