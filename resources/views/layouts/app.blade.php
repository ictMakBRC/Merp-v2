<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MERP') }}</title>

    <!-- App favicon -->
    <link rel="icon" href="{{ asset('assets/images/logos/fav-icon.png') }}" type="image/png" />
    <!-- App css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    @stack('css')

    {{-- @livewireStyles --}}
</head>

<body>
    <!--sidebar wrapper -->
    <livewire:layouts.partials.sidebar-navigation-component />
    <!--end sidebar wrapper -->

    <!--start header -->
    <livewire:layouts.partials.header-component />
    <!--end header -->

    <!--wrapper-->
    <div class="page-wrapper">

        <!-- Page Content-->
        <div class="page-content-tab">
            <!-- container -->
            <div class="container-fluid mt-3">
                {{ $slot }}
            </div>
            <!-- end container -->
            <livewire:layouts.partials.footer-component />
        </div>
        <!-- end page content -->

    </div>
    <!--end wrapper-->

    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>

    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/analytics-index.init.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>



    {{-- @livewireScripts --}}

    @stack('scripts')


</body>

</html>
