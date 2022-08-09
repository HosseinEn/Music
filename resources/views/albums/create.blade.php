@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row">
            @if($errors->any())
                @foreach($errors->all() as $error)
                    {{$error}}<br>
                @endforeach
            @endif
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
                    <label for="artist"> طول زمانی آلبوم:</label>
                    <input type="text" name="duration" class="form-control @error('duration') is-invalid @enderror">
                    <span class="invalid-feedback" role="alert">
                        @error('duration')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                    <smal>format=hour:min:sec</smal>
                </div>
                <div class="form-group">
                    <label for="artist">انتخاب هنرمند:</label>
                    <select id="artist" name="artist_id" placeholder="یک هنرمند را جتسجو  یا انتخاب کنید"
                            class="@error('artist_id') is-invalid @enderror">
                        <option value=""></option>
                        @forelse($artists as $artist)
                            <option value="{{ $artist->id }}">{{ $artist->name }}</option>
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
{{--                <div class="form-group">--}}
{{--                    <label for="artist">انتخاب آهنگ:</label>--}}
{{--                    <br>--}}
{{--                    <select name="artists[]" id="" class="form-select" multiple>--}}
{{--                        @forelse($artists as $artist)--}}
{{--                            <option value="{{ $artist->id }}" {{ in_array($artist->id, old('artists') ?? [])  ? 'selected' : '' }} >--}}
{{--                                {{ $artist->name }}--}}
{{--                            </option>--}}
{{--                        @empty--}}
{{--                            <option value="">هنرمندی در حال حاضر وجود ندارد!</option>--}}
{{--                        @endforelse--}}
{{--                    </select>--}}
{{--                </div>--}}
                <div class="form-group">
                    <label for="released_date">تاریخ انتشار آلبوم:</label>
                    <input type="date" id="start" name="released_date"
                           value="2018-07-22"
                           min="" max="" class="form-control">
                    <span class="invalid-feedback" role="alert">
                        @error('released_date')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                </div>
                <div class="form-group">
                    <label for="song">افزودن موسیقی:</label>
                    <input type="file" id="song" name="song" multiple="multiple" class="form-control @error('song') is-invalid @enderror"
                           value="{{old('song')}}">
                    <small>افزودن چندتایی امکان پذیر است.</small>
                    <span class="invalid-feedback" role="alert">
                        @error('song')
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

    <script type="application/javascript">
        $(document).ready(function () {
            $('select').selectize({
                sortField: 'text'
            });
        });
    </script>
@endsection
