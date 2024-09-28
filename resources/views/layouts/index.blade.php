<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.header')

        @yield('additional_style')
    </head>
<body class="">
    @yield('topnavbar')

    @yield('content')

    @yield('modal')

    @include('partials.script')

    @yield('additional_script')
</body>
</html>