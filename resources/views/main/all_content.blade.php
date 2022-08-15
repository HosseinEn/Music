@extends('main.index')

@section('content')

    @include('main.banner')
    <!-- block for animate navigation menu -->
    <div class="nav-animate"></div>

    @include('main.latest_albums')

    @include('main.promo')

    @include('main.latest_songs')

    @include('main.call_to_action')

    @include('main.genres')

    @include('main.events')

    @include('main.artists')

    @include('main.meet')

    @include('main.contact')    
@endsection