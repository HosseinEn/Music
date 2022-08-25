@extends('front.layouts.index')

@section('title', 'علاقه مندی ها')

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success" style="line-height: 275px;  height: 200px;" role="alert">
            {{session('success')}}
        </div>
    @endif
    @include('front.favorites.albums')
    @include('front.favorites.songs')
    @include('front.favorites.artists')
@endsection