<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="minimal-theme">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    {{-- <title>{{ $title }}</title> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MERP') }}</title>
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png" />
    <!--plugins-->
    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <!-- loader-->
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <!-- iziToast CSS -->
    <link href="{{ asset('assets/plugins/izitoast/css/iziToast.min.css') }}" rel="stylesheet" type="text/css">
    @livewireStyles
</head>

<body class="bg-login">
    <!--wrapper-->
    <div class="wrapper">
        <header class="login-header shadow">
            <nav class="navbar navbar-expand-lg navbar-light bg-white rounded fixed-top rounded-0 shadow-sm">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ route('login') }}">
                        <img src="{{ asset('assets/images/merp-logo.png') }}" width="140" alt="" />
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1"
                        aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent1">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <div class="btn-group">
                                    <a class="nav-link active dropdown-toggle" aria-current="page" href="#"
                                        data-bs-toggle="dropdown"><i
                                            class='bx bx-world me-1'></i>{{ Config::get('languages')[App::getLocale()] }}</a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                                        <a class="dropdown-item" href="{{ route('lang', 'en') }}">English</a>
                                        <a class="dropdown-item" href="{{ route('lang', 'ar') }}">Arabic</a>
                                        <a class="dropdown-item" href="{{ route('lang', 'fr') }}">French</a>
                                        <a class="dropdown-item" href="{{ route('lang', 'es') }}">Spanish</a>
                                        <a class="dropdown-item" href="{{ route('lang', 'sw') }}">Swahili</a>
                                        <a class="dropdown-item" href="{{ route('lang', 'pt') }}">Portuguese</a>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-4">
            <div class="container-fluid">
                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                    <div class="col mx-auto">
                        {{ $slot }}

                    </div>
                </div>
            </div>
        </div>
        <footer class="bg-white shadow-sm border-top p-2 text-center fixed-bottom">
            <p class="mb-0"><span>&copy; {{ date('Y') }} <a href="#" class="text-success fw-bold">Makerere University Biomedical Research Centre</a></span>. All right reserved.</p>
        </footer>

    </div>
    <!--end wrapper-->

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/plugins/izitoast/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/sort.js') }}"></script> --}}
    <!--Password show & hide js -->
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });
    </script>

    <!--app JS-->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    @livewireScripts

    <script>
        window.addEventListener('alert', event => {

            if (event.detail.type == 'success') {
                iziToast.success({
                    title: 'Success!',
                    message: `${event.detail.message}`,
                    timeout: 5000,
                    position: 'topRight'
                });
            }

            if (event.detail.type == 'Error') {
                iziToast.error({
                    title: 'Error!',
                    message: `${event.detail.message}`,
                    timeout: 5000,
                    position: 'topRight'
                });
            }

            if (event.detail.type == 'warning') {
                iziToast.warning({
                    title: 'Warning!',
                    message: `${event.detail.message}`,
                    timeout: 5000,
                    position: 'topRight'
                });
            }
        });


        window.addEventListener('switch-theme', event => {
            $("html").attr("class", `${event.detail.theme}`)
        });
        window.addEventListener('swal:modal', event => {
            swal({
                title: event.detail.message,
                text: event.detail.text,
                icon: event.detail.type,
            });
        });

        window.addEventListener('swal:confirm', event => {
            swal({
                    title: event.detail.message,
                    text: event.detail.text,
                    icon: event.detail.type,
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.livewire.emit('remove');
                    } else {
                        window.livewire.emit('cancel');
                    }
                });
        });
    </script>
</body>

</html>
