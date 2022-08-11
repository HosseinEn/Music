@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="{{ route('admin.home') }}">خانه</a></li>
                    <li><a href="{{ route('albums.index') }}">لیست آلبوم ها</a></li>
                    <li>ایجاد آلبوم جدید</li>
                </ol>
            </nav>

            <form action="{{ route('albums.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">نام آلبوم:</label>
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
                    <small>در صورت خالی گذاشتن این فیلد، به صورت خودکار نام آلبوم به اسلاگ تبدیل خواهد شد.</small>
                    <span class="invalid-feedback" role="alert">
                        @error('slug')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                </div>
                <div class="form-group">
                    <label for="duration_seconds"> طول زمانی آلبوم:</label>
                    <br>
                    <input value="{{ old('duration_seconds') }}" type="number" style="width: 8rem;" class="@error('duration_seconds') is-invalid @enderror" name="duration_seconds" min="0" max="60">
                    <span class="invalid-feedback" role="alert">
                        @error('duration_seconds')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                    <input value="{{ old('duration_minutes') }}" type="number" style="width: 8rem;" class="@error('duration_minutes') is-invalid @enderror" name="duration_minutes" min="0" max="60">
                    <span class="invalid-feedback" role="alert">
                        @error('duration_minutes')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                    <input value="{{ old('duration_hours') }}" type="number" style="width: 8rem;" class="@error('duration_hours') is-invalid @enderror" name="duration_hours" min="0">
                    <span class="invalid-feedback" role="alert">
                        @error('duration_hours')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                    <small>format=hour:min:sec</small>
                </div>
                <div class="form-group">
                    <label for="artist">انتخاب هنرمند:</label>
                    <select id="artist" name="artist_id" placeholder="یک هنرمند را جتسجو  یا انتخاب کنید"
                            class="@error('artist_id') is-invalid @enderror">
                        <option value=""></option>
                        @forelse($artists as $artist)
                            <option value="{{ $artist->id }}" {{ old('artist_id') == $artist->id ? 'selected' : '' }}>{{ $artist->name }}</option>
                        @empty
                            هنرمندی در حال حاضر وجود ندارد!
                        @endforelse
                    </select>
                    <span class="invalid-feedback" role="alert">
                        @error('artist_id')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                </div>
                <div class="form-group">
                    <label for="released_date">تاریخ انتشار آلبوم:</label>
                    <input type="date" id="start" name="released_date"
                        value="{{ old('released_date') }}"
                        min="" max="" class="form-control @error('released_date') is-invalid @enderror">
                    <span class="invalid-feedback" role="alert">
                        @error('released_date')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                </div>
                <div class="form-group">
                    <label for="songs">افزودن موسیقی:</label>
                    <select id="songs" name="songs[]" class="@error('songs') is-invalid @enderror" multiple
                            placeholder="موسیقی را جتسجو  یا انتخاب کنید">
                        @forelse($songs as $song)
                            <option value="{{ $song->id }}" {{ in_array($song->id, old('songs') ?? [])  ? 'selected' : '' }} >
                                {{ $song->name }}
                            </option>
                        @empty
                            <option value="">موسیقی در حال حاضر وجود ندارد!</option>
                        @endforelse
                    </select>
                    <small>افزودن چندتایی امکان پذیر است.</small>
                    <span class="invalid-feedback" role="alert">
                        @error('songs')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                </div>
                <div class="form-group">
                    <label for="cover">انتخاب تصویر:</label>
                    <input type="file" name="cover" class="form-control  @error('cover') is-invalid @enderror" id="cover"
                        value="{{old('cover')}}">
                    <span class="invalid-feedback" role="alert">
                        @error('cover')
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
