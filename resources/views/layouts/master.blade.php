<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title' , 'Home Page')</title>
    <style>
        @yield('style-css');
    </style>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
    @section('script')

    @show
</body>
</html>