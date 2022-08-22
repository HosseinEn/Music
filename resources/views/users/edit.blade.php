@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="{{ route('admin.home') }}">خانه</a></li>
                    <li><a href="{{ route('users.index') }}">لیست کاربران</a></li>
                    <li>ویرایش کاربر {{$user->name}}</li>
                </ol>
            </nav>
            <form class="bg-dark text-white" action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">نام:</label>
                    <input type="text" id="name" name="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{$user->name}}">
                    <span class="invalid-feedback" role="alert">
                        @error('name')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                </div>
                <div class="form-group">
                    <label for="email">ایمیل:</label>
                    <input type="email" id="email" name="email"
                        class="form-control @error('email') is-invalid @enderror" value="{{$user->email}}">
                    <span class="invalid-feedback" role="alert">
                        @error('email')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </span>
                </div>
                @can('promote', $user)
                    <div class="form-group">
                        <label for="is_admin">نقش:</label>
                        <select name="is_admin" id="is_admin">
                            <option value="0" selected>کاربر</option>
                            <option value="1">ادمین</option>
                        </select>
                        <span class="invalid-feedback" role="alert">
                            @error('email')
                                <strong>{{ $message }}</strong>
                            @enderror
                        </span>
                    </div>
                @endcan
                <div class="form-group">
                    <button type="submit" class="btn btn-warning">ویرایش</button>
                </div>
            </form>
        </div>
    </div>
@endsection