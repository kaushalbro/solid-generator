<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('includes.header')
@section('header_title')
    @yield('title')
@stop
<body>
    @include('includes.navbar')
    @include('includes.sidebar')
    @yield('breadcrumb')
        <section class="">
                @yield('content')
        </section>
    @include('includes.footer')
    @include('includes.scripts')
    @stack('scripts')
</body>
</html>


