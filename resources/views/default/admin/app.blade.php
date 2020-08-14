<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{request()->get('app')->name}}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600">
    <link rel="stylesheet" href="{{ mix('css/admin.css') }}">
    <link rel="stylesheet" href="{{ mix('css/vendor.css') }}">

    <script type="text/javascript" src="{{ mix('js/vendor.js') }}"></script>
</head>
<body
    class="vertical-layout vertical-menu-modern 2-columns floating menu-expanded static"
    data-menu="vertical-menu-modern" data-col="2-columns">

    @include('admin.panels.sidebar')

    <!-- BEGIN: Content-->
    <div class="app-content content">

        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>

        @include('admin.panels.navbar')

        <div class="content-wrapper">

            @include('admin.panels.breadcrumb')

            <div class="content-body">
                @yield('content')
            </div>
        </div>

    </div>
    <!-- End: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    @include('admin.panels.footer')

    <script type="text/javascript" src="{{ mix('js/admin.js') }}"></script>
</body>
</html>
