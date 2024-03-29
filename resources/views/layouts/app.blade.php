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
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <!-- Include Select2 library and CSS -->
    {{-- <script src="{{ asset('assets/libs/select2/css/select2.min.css') }}"></script> --}}

    <!-- iziToast CSS -->
    <link href="{{ asset('assets/libs/izitoast/css/iziToast.min.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('assets/libs/starability/starability-css/starability-all.css') }}" rel="stylesheet" type="text/css" />
    <!--<script src="{{ asset('assets/libs/ckeditor/ckeditor.js') }}"></script>-->
    <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>


    @stack('css')

    @livewireStyles
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
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-editor.init.js') }}"></script>

    {{-- <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script> --}}
    <script src="{{ asset('assets/libs/izitoast/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert/sweetalert.min.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    {{-- <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script> --}}

    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/index.js') }}"></script>

    @livewireScripts

    @stack('scripts')
    
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    
</body>

</html>
