<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('backend.admin.includes.header')
@section('header_title')
    @yield('title')
@stop
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
    @include('backend.admin.includes.navbar')
    @include('backend.admin.includes.sidebar')
    <div class="content-wrapper">
        @yield('breadcum')
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
    </div>
    @include('backend.admin.includes.footer')
</div>
@include('backend.admin.includes.scripts')
@stack('scripts')
</body>
</html>
