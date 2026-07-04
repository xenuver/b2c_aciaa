@extends('layouts.base')

@section('title', 'ACIAA — Premium Women\'s Fashion')

@section('body')
    <!-- Navigation -->
    @include('layouts.navigation')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
    @include('components.whatsapp-button')
@endsection
