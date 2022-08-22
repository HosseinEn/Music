@extends('front.layouts.index')

@section('content')

    @if (Session::has('success'))
        <div class="alert alert-success" style="line-height: 275px;  height: 200px;" role="alert">
            {{session('success')}}
        </div>
    @endif

    @include('front.main.banner')

    <!-- block for animate navigation menu -->
    <div class="nav-animate"></div>

    @include('front.main.search')

    @include('front.main.latest_albums')

    @include('front.main.popular_albums')

    {{-- @include('front.main.promo') --}}

    @include('front.main.latest_songs')

    @include('front.main.popular_songs')

    @include('front.main.call_to_action')

    @include('front.main.genres')

    @include('front.main.events')

    @include('front.main.artists')

    @include('front.main.meet')

    @include('front.main.contact')
@endsection
