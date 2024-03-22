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
   
    <!-- iziToast CSS -->
    <link href="{{ asset('assets/libs/izitoast/css/iziToast.min.css') }}" rel="stylesheet" type="text/css">

    @stack('css')

    @livewireStyles
</head>

<body>

    <div class="wrapp">
        <nav class="navbar navbar-expand-lg navbar-light bg-white rounded fixed-to rounded-0 shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ asset('assets/images/logos/merp-logo.png') }}" alt="logo-banner"
                        style="height: 50px; width: 100%; display: block;">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1"
                    aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent1">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        {{-- @include('layouts.language') --}}

                        <li class="nav-item">
                            <div class="btn-group  me-5">
                                <a class="nav-link active dropdown-toggle" aria-current="page" href="#"
                                    data-bs-toggle="dropdown">
                                    {{-- @php
                                        $lang = Config::get('languages')[App::getLocale()];
                                    @endphp --}}
                                    <img alt="User-avatar"
                                        src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('assets/images/users/user-vector.png') }}"
                                        height="26">
                                    <span class="user-name mb-0">{{ Auth::user()->name }}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-down">
                                    <a class="dropdown-item" href="{{ route('user.account') }}"><i
                                            class="bx bx-user"></i><span>{{ __('public.profile') }}</span></a>
                                    <a class="dropdown-item" href="{{ route('home') }}"><i
                                            class="bx bx-home"></i><span>{{ __('public.home') }}</span></a>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="{{ route('logout') }}" target="_blank" class="dropdown-item"
                                            onclick="event.preventDefault();
                    this.closest('form').submit();">
                                            <i class="bx bx-log-out"></i>{{ __('Logout') }}
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="landing-pag d-flex align-items-center justify-content-center">
            <div class="container">
                <div class="row mb-5 mt-3">
                    <div class="clearfix"></div>
                    {{$slot}}
                </div>
                <!-- end wrapper -->
            </div>
        </div>
    </div>

    <footer class="bg-white shadow-sm border-top p-2 text-center fixed-bottom">
        <p class="mb-0"><span>&copy; {{ date('Y') }} <a href="#"
                    class="text-success">{{ organizationInfo()->facility_name??'MERP' }}</a></span>
            {{ __('public.copyright') }}
        </p>
    </footer>

    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>

    {{-- <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script> --}}
    <script src="{{ asset('assets/libs/izitoast/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert/sweetalert.min.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/index.js') }}"></script>

    @livewireScripts

    @stack('scripts')
    
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    
</body>

</html>
