@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="{{ route('admin.home') }}">خانه</a></li>
                    <li><a href="{{ route('albums.index') }}">لیست آلبوم ها</a></li>
                    <li>ویراش آلبوم {{ $album->name }}</li>
                </ol>
            </nav>

            @include('messages')

            <div class="row">
                <h3 for="songs_table">موسیقی های آلبوم:</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th class="text-center">نام آهنگ</th>
                        <th class="text-center">حذف از آلبوم</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($album->songs as $song)
                        <tr class="text-center">
                            <td>{{ $song->name}}</td>
                            <td>
                                <form action="{{ route('album.song.delete')}}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{ $song->id }}" name="song_id">
                                    <input type="submit" class="btn btn-danger" value="حذف">
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>موسیقی ای در این آلبوم وجود ندارد!</td>
                            <td></td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <form action="{{ route('albums.update', $album->slug) }}" method="POST" enctype="multipart/form-data"
                class="bg-dark text-white">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">نام آلبوم:</label>
                    <input type="text" id="name" name="name"
                           class="form-control @error('name') is-invalid @enderror" value="{{ $album->name }}">
                    <span class="invalid-feedback" role="alert">
                        @error('name')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                </div>
                <div class="form-group">
                    <label for="slug">slug:</label>
                    <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror"
                           value="{{ $album->slug }}">
                    <small>برحسب نام خودکار بروزرسانی شود.</small>
                    <input type="checkbox" name="slug_based_on_name">
                    <span class="invalid-feedback" role="alert">
                        @error('slug')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                </div>
                <div class="form-group">
                    <label for="published">وضعیت آلبوم:</label>
                    <select name="published" id="published" class="@error('published') is-invalid @enderror">
                        <option value="0"{{ $album->published == "0" ? 'selected' : ''}}>منتشر نشده</option>
                        <option value="1"{{ $album->published == "1" ? 'selected' : ''}}>منتشر شده</option>
                    </select>
                    <small>با تغییر وضعیت انتشار آلبوم، وضعیت انتشار موسیقی های مرتبط نیز به طور خودکار تغییر می کند.</small>
                    <span class="invalid-feedback" role="alert">
                        @error('published')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                </div>
                <div class="form-group">
                    <label for="autopublishe">فعالسازی انتشار خودکار:</label>
                    <input type="checkbox" name="auto_publish" id="autopublish" {{$album->auto_publish ? 'checked' : ''}}
                    onchange="document.querySelector('#publish_date').disabled = !document.querySelector('#autopublish').checked;">
                </div>
                <div class="form-group">
                    <label for="publish_date">تاریخ انتشار خودکار موسیقی در وبسایت:</label>
                    <input type="date" id="publish_date" name="publish_date"
                        value="{{ $album->publish_date }}" {{$album->auto_publish ? '' : 'disabled' }}
                        min="" max="" class="form-control @error('publish_date') is-invalid @enderror">
                    <small>در صورتی که تاریخی پس از حال حاضر را انتخاب نمایید و وضعیت انتشار را "منتشر نشده" قرار دهید، موسیقی به طور خودکار در تاریخ مورد نظر منتشر خواهد شد.</small>
                    <span class="invalid-feedback" role="alert">
                        @error('publish_date')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                </div>
                <div class="form-group">
                    <label for="duration_seconds"> طول زمانی آلبوم:</label>
                    <input type="text" name="duration" value="{{ $album->duration }}" class="form-control">
                    <small>format=hour:min:sec</small>
                    <span class="invalid-feedback" role="alert">
                        @error('duration')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                </div>
                <div class="form-group">
                    <label for="tags">ژانرها:</label>
                    <select id="tags" name="tags[]" class="@error('tags') is-invalid @enderror" multiple
                        placeholder="ژانر را جتسجو  یا انتخاب کنید">
                        @forelse($tags as $tag)
                            <option value="{{ $tag->id }}" {{ in_array($tag->id, $album->tagIDs())  ? 'selected' : '' }} >
                                {{ $tag->name }}
                            </option>
                        @empty
                            <option value="">ژانری در حال حاضر وجود ندارد!</option>
                        @endforelse
                    </select>
                    <span class="invalid-feedback" role="alert">
                        @error('tags')
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
                            <option value="{{ $artist->id }}" {{ $album->artist->id == $artist->id ? 'selected' : '' }}>{{ $artist->name }}</option>
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
                           value="{{ $album->released_date }}"
                           min="" max="" class="form-control @error('released_date') is-invalid @enderror">
                    <span class="invalid-feedback" role="alert">
                        @error('released_date')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                </div>
                <div class="form-group">
                    <br>
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
                    @if($album->image)
                        <img class="img-thumbnail mt-2" style="height: 70px;" src="{{ $album->image->url() }}" alt="album_image">
                    @endif
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-warning">ویرایش</button>
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
