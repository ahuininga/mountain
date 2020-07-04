<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | {{request()->get('app')->name}}</title>
</head>
<body>
    <div id="content">
        @yield('content')
    </div>
</body>
</html>
