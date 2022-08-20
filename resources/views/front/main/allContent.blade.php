@extends('front.layouts.index')

@section('content')

    @include('front.main.banner')

    <!-- block for animate navigation menu -->
    <div class="nav-animate"></div>

    @include('front.main.search')

    @include('front.main.latest_albums')

    {{-- @include('front.main.promo') --}}

    @include('front.main.latest_songs')

    @include('front.main.call_to_action')

    @include('front.main.genres')

    @include('front.main.events')

    @include('front.main.artists')

    @include('front.main.meet')

    {{-- @include('front.main.contact') --}}
@endsection
