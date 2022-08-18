@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.home') }}">خانه</a></li>
                <li><a href="{{ route('songs.index') }}">لیست موسیقی ها</a></li>
                <li>ویرایش موسیقی {{$song->name}}</li>
            </ol>
        </nav>
        <form action="{{ route('songs.update', $song->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">نام موسیقی:</label>
                <input type="text" id="name" name="name"
                    class="form-control @error('name') is-invalid @enderror" value="{{$song->name}}">
                <span class="invalid-feedback" role="alert">
                    @error('name')
                        <strong>{{ $message }}</strong>
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="slug">slug:</label>
                <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror"
                    value="{{$song->slug}}">
                <small>برحسب نام خودکار بروزرسانی شود.</small>
                <input type="checkbox" name="slug_based_on_name">
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
                        <option value="{{ $artist->id }}" {{ $song->artist->id == $artist->id ? 'selected' : '' }}>{{ $artist->name }}</option>
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
                <label for="quality">کیفیت موجود:</label>
                @if($song->songFiles()->quality128Exists() && $song->songFiles()->quality320Exists())
                    <input type="text" class="form-control" value="128 & 320" disabled>
                @endif
                @if($song->songFiles()->quality128Exists() && !$song->songFiles()->quality320Exists())
                    <input type="text" class="form-control" value="128" disabled>
                @endif
                @if(!$song->songFiles()->quality128Exists() && $song->songFiles()->quality320Exists())
                    <input type="text" class="form-control" value="320" disabled>
                @endif
                <span class="invalid-feedback" role="alert">
                    @error('quality')
                        <strong>{{ $message }}</strong>
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="song_file">فایل موسیقی:</label>
                <br>
                <span class="badge bg-secondary mb-1">128kbps</span>
                <input type="file" name="song_file_128" class="form-control @error('song_file_128') is-invalid @enderror">
                @if($song->songFiles()->quality128Exists())
                    <a href="{{ route('admin.download.song', $song->slug) }}?quality=128">
                        <button type="button" class="btn btn-success mt-3">Download 128kbps</button>
                    </a>
                @endif
                <span class="invalid-feedback" role="alert">
                    @error('song_file_128')
                        <strong>{{ $message }}</strong>
                    @enderror
                </span>
                <br>
                <span class="badge bg-secondary mb-1">320kbps</span>
                <input type="file" name="song_file_320" class="form-control @error('song_file_320') is-invalid @enderror">
                @if($song->songFiles()->quality320Exists())
                    <a href="{{ route('admin.download.song', $song->slug) }}?quality=320">
                        <button type="button" class="btn btn-success mt-3">Download 320kbps</button>
                    </a>
                @endif
                <span class="invalid-feedback" role="alert">
                    @error('song_file_320')
                        <strong>{{ $message }}</strong>
                    @enderror
                </span>
            </div>
            @if($song->album)
                <p class="text-primary"><b>اعمال تغییرات بر روی وضعیت و انتشار خودکار موسیقی عضو آلبوم امکان پذیر نمی باشد.</b></p>
                <div style="background-color: gray;">
                    <div class="form-group">
                        <label for="">وضعیت موسیقی:</label>
                        <select name="" id="" disabled >
                            <option value="0"{{ $song->album->published == 0 ? 'selected' : ''}}>منتشر نشده</option>
                            <option value="1"{{ $song->album->published == 1 ? 'selected' : ''}}>منتشر شده</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">فعالسازی انتشار خودکار:</label>
                        <input type="checkbox" {{$song->album->auto_publish ? 'checked' : ''}} disabled>
                    </div>
                    <div class="form-group">
                        <label for="">تاریخ انتشار خودکار موسیقی در وبسایت:</label>
                        <input type="date" id="" name=""
                            value="{{ $song->album->publish_date }}"
                            min="" max="" class="form-control" disabled>
                    </div>
                </div>
            @else
                <div class="form-group">
                    <label for="published">وضعیت موسیقی:</label>
                    <select name="published" id="published" class="@error('published') is-invalid @enderror">
                        <option value="0"{{ $song->published == 0 ? 'selected' : ''}}>منتشر نشده</option>
                        <option value="1"{{ $song->published == 1 ? 'selected' : ''}}>منتشر شده</option>
                    </select>
                    <span class="invalid-feedback" role="alert">
                        @error('published')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                </div>
                <div class="form-group">
                    <label for="autopublishe">فعالسازی انتشار خودکار:</label>
                    <input type="checkbox" name="auto_publish" id="autopublish" {{$song->auto_publish ? 'checked' : ''}}
                    onchange="document.querySelector('#publish_date').disabled = !document.querySelector('#autopublish').checked;">
                </div>
                <div class="form-group">
                    <label for="publish_date">تاریخ انتشار خودکار موسیقی در وبسایت:</label>
                    <input type="date" id="publish_date" name="publish_date"
                        value="{{ $song->publish_date }}" {{$song->auto_publish ? '' : 'disabled' }}
                        min="" max="" class="form-control @error('publish_date') is-invalid @enderror">
                    <small>در صورتی که تاریخی پس از حال حاضر را انتخاب نمایید و وضعیت انتشار را "منتشر نشده" قرار دهید، موسیقی به طور خودکار در تاریخ مورد نظر منتشر خواهد شد.</small>
                    <span class="invalid-feedback" role="alert">
                        @error('publish_date')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                </div>    
            @endif

            <div class="form-group">
                <label for="tags">ژانرها:</label>
                <select id="tags" name="tags[]" class="@error('tags') is-invalid @enderror" multiple
                    placeholder="ژانر را جتسجو  یا انتخاب کنید">
                    @forelse($tags as $tag)
                        <option value="{{ $tag->id }}" {{ in_array($tag->id, $song->tagIDs())  ? 'selected' : '' }} >
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
                <input type="text" class="form-control @error('duration') is-invalid @enderror" name="duration" value="{{ $song->songFiles->first()->duration }}">
                <span class="invalid-feedback" role="alert">
                    @error('duration')
                        <strong>{{ $message }}</strong>
                    @enderror
                </span>
                <small>format=hour:min:sec</small>
            </div>
            <div class="form-group">
                <label for="released_date">تاریخ انتشار موسیقی:</label>
                <input type="date" id="start" name="released_date"
                    value="{{ $song->released_date }}"
                    min="" max="" class="form-control @error('released_date') is-invalid @enderror">
                <span class="invalid-feedback" role="alert">
                    @error('released_date')
                        <strong>{{ $message }}</strong>
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="album">ویرایش آلبوم:</label>
                <select id="album" name="album" class="@error('album') is-invalid @enderror" 
                    placeholder="آلبوم را جتسجو  یا انتخاب کنید">
                    <option value=""></option>
                    @forelse($albums as $album)
                        <option value="{{ $album->id }}" {{ $album->id == ($song->album ? $song->album->id : '') ? 'selected' : '' }}>
                            {{ $album->name }}
                        </option>
                    @empty
                        <option value="">آلبومی در حال حاضر وجود ندارد!</option>
                    @endforelse
                </select>
                <small> می تواند خالی باشد. (برای حذف آلبوم می توانید روی فیلد کلیک نمایید و سپس کلید backspace را روی کیبورد خود بفشارید)</small>
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
                @if($song->image) 
                    <img src="{{ $song->image->url() }}" alt="Song image">
                @endif
                <span class="invalid-feedback" role="alert">
                    @error('cover')
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