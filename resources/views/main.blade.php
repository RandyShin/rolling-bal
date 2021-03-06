<!DOCTYPE html>
<html lang="en">

@include('partials._header')

<body>

@include('partials._nav')

<div class="container">

    {{--{{ Auth::check() ? "Logged In" : "Logged Out" }}--}}
    @include('partials._messages')

    @yield('content')

    @include('partials._footer')

</div> <!-- end of .container -->

@include('partials._javascript')

@yield('scripts')

</body>
</html>