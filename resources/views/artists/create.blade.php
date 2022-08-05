@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <form action="{{ route('artists.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">نام هنرمند:</label>
                    <input type="text" id="name" name="name"
                        class="form-control @error('name') is-invalid @enderror">
                    <span class="invalid-feedback" role="alert">
                        @error('name')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                </div>
                <div class="form-group">
                    <label for="slug">slug:</label>
                    <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror">
                    <span class="invalid-feedback" role="alert">
                        @error('slug')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                </div>
                <div class="form-group">
                    <label for="file">انتخاب تصویر:</label>
                    <input type="file" name="image" class="form-control  @error('image') is-invalid @enderror" id="file">
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
