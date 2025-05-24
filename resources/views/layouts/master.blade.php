<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light" data-sidebar="dark"
    data-sidebar-size="lg">

<head>
    <meta charset="utf-8" />
    <title>@yield('title')| Admin Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Smart Jamia :: Campus Management Portal" name="description" />
    <meta content="Smart Jamia" name="itwing" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}">
    @include('layouts.head-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <style>
        .required:after {
            content: " *";
            color: red;
        }
    </style>
 
</head>

@section('body')
    @include('layouts.body')
@show
<!-- Begin page -->
<div id="layout-wrapper">
    @include('layouts.topbar')
    @include('layouts.sidebar')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
        <script>
            $('.form-prevent-multiple-submits').on('submit', function() {
                $('.button-prevent-multiple-submits').attr('disabled', true);
                $('.button-prevent-multiple-submits .spinner').show();
            });
            toastr.options = {
                "closeButton": true,
            };
            @if (Session::has('success'))
                toastr.success("{{ Session::get('success') }}");
                @php
                    Session::forget('success');
                @endphp
            @endif
        
            @if (Session::has('error'))
                toastr.error("{{ Session::get('error') }}");
                @php
                    Session::forget('error');
                @endphp
            @endif
            @if (Session::has('warning'))
                toastr.warning("{{ Session::get('warning') }}");
                @php
                    Session::forget('warning');
                @endphp
            @endif
        
            @if ($errors->any())
                // @php
                //     dump($errors->all());
                // @endphp
                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}");
                @endforeach
            @endif
        </script>
        @include('layouts.footer')
    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->

{{-- @include('layouts.customizer') --}}

<!-- JAVASCRIPT -->
@include('layouts.vendor-scripts')
</body>

</html>
