@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.home') }}">خانه</a></li>
                <li><a href="{{ route('songs.index') }}">لیست موسیقی ها</a></li>
                <li>ایجاد موسیقی جدید</li>
            </ol>
        </nav>
        @if($errors->any())
            @foreach($errors->all() as $error)
                {{$error}}
            @endforeach
        @endif
        <form action="{{ route('songs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">نام موسیقی:</label>
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
                <small>در صورت خالی گذاشتن این فیلد، به صورت خودکار نام موسیقی به اسلاگ تبدیل خواهد شد.</small>
                <span class="invalid-feedback" role="alert">
                    @error('slug')
                        <strong>{{ $message }}</strong>
                    @enderror
                </span>
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
                <a href="{{ route('artists.create') }}">ایجاد هنرمند جدید</a>
                <span class="invalid-feedback" role="alert">
                    @error('artist_id')
                        <strong>{{ $message }}</strong>
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="quality">کیفیت:</label>
                <select name="quality" id="quality">
                    <option value="128" {{ old('quality') == "128" ?  'selected' : ''}}>128</option>
                    <option value="320" {{ old('quality') == "320" ?  'selected' : ''}}>320</option>
                    <option value="128_320" {{ old('quality') == "128_320" ?  'selected' : ''}}>128 و 320</option>
                </select>
                <span class="invalid-feedback" role="alert">
                    @error('quality')
                        <strong>{{ $message }}</strong>
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="song_file">فایل موسیقی:</label>
                <br>
                <small><b>در این بخش می توانید بر حسب کیفیت مشخص شده در فیلد بالا، یک موسیقی در بخش ۱۲۸ یا ۳۲۰ یا هردو آپلود نمایید.</b></small>
                <br>
                <span class="badge bg-secondary mb-1">128kbps</span>
                <input type="file" name="song_file_128" class="form-control @error('song_file_128') is-invalid @enderror">
                <span class="invalid-feedback" role="alert">
                    @error('song_file_128')
                        <strong>{{ $message }}</strong>
                    @enderror
                </span>
                <br>
                <span class="badge bg-secondary mb-1">320kbps</span>
                <input type="file" name="song_file_320" class="form-control @error('song_file_320') is-invalid @enderror">
                <span class="invalid-feedback" role="alert">
                    @error('song_file_320')
                        <strong>{{ $message }}</strong>
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="published">وضعیت موسیقی:</label>
                <select name="published" id="published" class="@error('published') is-invalid @enderror">
                    <option value="0"{{ old('published') == "0" ? 'selected' : ''}}>منتشر نشده</option>
                    <option value="1"{{ old('published') == "1" ? 'selected' : ''}}>منتشر شده</option>
                </select>
                <span class="invalid-feedback" role="alert">
                    @error('published')
                        <strong>{{ $message }}</strong>
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="tags">ژانرها:</label>
                <select id="tags" name="tags[]" class="@error('tags') is-invalid @enderror" multiple
                    placeholder="ژانر را جتسجو  یا انتخاب کنید">
                    @forelse($tags as $tag)
                        <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags') ?? [])  ? 'selected' : '' }} >
                            {{ $tag->name }}
                        </option>
                    @empty
                        <option value="">موسیقی در حال حاضر وجود ندارد!</option>
                    @endforelse
                </select>
                <small>می تواند خالی باشد.</small>
            </div>
            <div class="form-group">
                <label for="duration_seconds"> طول زمانی موسیقی:</label>
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
                <label for="released_date">تاریخ انتشار موسیقی:</label>
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
                <label for="album">افزودن به آلبوم:</label>
                <select id="album" name="album" class="@error('album') is-invalid @enderror" 
                    placeholder="آلبوم را جتسجو  یا انتخاب کنید">
                    <option value=""></option>
                    @forelse($albums as $album)
                        <option value="{{ $album->id }}" {{ $album->id == old('album') ? 'selected' : '' }}>
                            {{ $album->name }}
                        </option>
                    @empty
                        <option value="">آلبومی در حال حاضر وجود ندارد!</option>
                    @endforelse
                </select>
                <small>می تواند خالی باشد.</small>
                <br>
                <a href="{{ route('albums.create') }}">ایجاد آلبوم جدید</a>
                <span class="invalid-feedback" role="alert">
                    @error('released_date')
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