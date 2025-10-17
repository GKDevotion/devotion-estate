<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'Front Side')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('frontend.layouts.partials.styles')
    @yield('styles')

    <script>
        var token = $('meta[name="csrf-token"]').attr("content");
        var url = '{{url("/")}}';
    </script>
</head>

<body>
    
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->

    <!-- page container area start -->
    <div class="page-container">

        @if( !$isHide )
            @include('frontend.layouts.partials.sidebar')
        @else
            <style>
                .page-container{
                    padding-left: 0 !important;
                }
            </style>
        @endif

        <!-- main content area start -->
        <div class="main-content">

            @if( !$isHide )
                @include('frontend.layouts.partials.header')
            @endif

            @yield('admin-content')
        </div>

        <!-- main content area end -->
        @include('frontend.layouts.partials.footer')
    </div>
    <!-- page container area end -->

    @include('frontend.layouts.partials.offsets')
    @include('frontend.layouts.partials.scripts')
    @yield('scripts')
</body>

</html>
