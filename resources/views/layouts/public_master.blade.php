<!doctype html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">

<head>
    <meta charset="utf-8" />
    <title>@yield('title')| Jamia Campus Management Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Smart Jamia :: Campus Management Portal" name="description" />
    <meta content="Smart Jamia" name="itwing" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico')}}">
    @include('layouts.head-css')
</head>

@section('body')
    @include('layouts.body')
@show
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.public_topbar')
         @include('layouts.public_sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content" style="margin-top: 10px;">
                <div class="container-fluid">
                    <h3 style="padding: 14px;
                    text-align: center;
                    font-weight: bold;
                    font-size: 22px;"> Student Data form</h3>
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    @include('layouts.customizer')

    <!-- JAVASCRIPT -->
    @include('layouts.vendor-scripts')
</body>

</html>
