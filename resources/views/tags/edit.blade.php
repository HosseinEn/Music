@extends('layouts.app')

@section('title', 'ویرایش ژانر')

@section('content')
    <div class="container">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="{{ route('admin.home') }}">خانه</a></li>
                    <li><a href="{{ route('tags.index') }}">لیست ژانر ها</a></li>
                    <li>ویرایش ژانر {{ $tag->name }}</li>
                </ol>
            </nav>

            <form class="bg-dark text-white" action="{{ route('tags.update', $tag->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <div class="form-group">
                    <label for="name">نام ژانر:</label>
                    <input type="text" id="name" name="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{ $tag->name }}">
                    <span class="invalid-feedback" role="alert">
                        @error('name')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                </div>
                <div class="form-group">
                    <label for="slug">slug:</label>
                    <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror"
                           value="{{ $tag->slug }}">
                    برحسب نام خودکار بروزرسانی شود.
                    <input type="checkbox" name="slug_based_on_name">
                    <span class="invalid-feedback" role="alert">
                        @error('slug')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-warning">ویرایش</button>
                </div>
            </form>
        </div>
    </div>


@endsection
