<x-guest-layout>
    <div class="card-body p-0 auth-header-box">
        <div class="text-center p-3">
            <a href="{{ route('login') }}" class="logo logo-admin">
                <img src="{{ asset('assets/images/logos/merp-logo.png') }}" height="50" alt="logo" class="auth-logo">
            </a>
        </div>
    </div>
    <div class="card-body pt-0">
        <form method="POST" action="{{ route('login-guest') }}" class="my-4">
            @csrf
            @include('layouts.messages')

            <div class="form-group mb-2">
                <label class="form-label" for="useremail">{{ __('public.email') }}</label>
                <input type="email" class="form-control" id="useremail" required name="email"
                    value="{{ old('email') }}" autocomplete="off" placeholder="Enter email">
            </div>
            <!--end form-group-->

            <div class="form-group">
                <label class="form-label" for="userpassword">{{ __('public.password') }}</label>
                <input type="password" class="form-control" id="userpassword" placeholder="Enter Password"
                    name="password" required autocomplete="off">
            </div>
            <!--end form-group-->

            <div class="form-group row mt-3">
                <div class="col-sm-6">
                    <div class="form-check form-switch form-switch-success">
                        <input class="form-check-input" type="checkbox" id="customSwitchSuccess" name="remember">
                        <label class="form-check-label" for="customSwitchSuccess">{{ __('public.rememberme') }}</label>
                    </div>
                </div>
                <!--end col-->
                <div class="col-sm-6 text-end">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-muted font-13"><i
                                class="dripicons-lock"></i>{{ __('public.forgotpass') }}</a>
                    @endif
                </div>
                <!--end col-->
            </div>
            <!--end form-group-->

            <div class="form-group mb-0 row">
                <div class="col-12">
                    <div class="d-grid mt-3">
                        <button class="btn btn-primary" type="button">{{ __('public.login') }} <i
                                class="fas fa-sign-in-alt ms-1"></i></button>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end form-group-->
        </form>
        <!--end form-->
        <div class="m-3 text-center text-muted">
            <p class="mb-0">What to know more about us ?</p>
        </div>
        <hr class="hr-dashed mt-4">
        <div class="text-center mt-n5">
            <h6 class="card-bg px-3 my-4 d-inline-block">Follow us on</h6>
        </div>
        <div class="d-flex justify-content-center mb-1">
            <a href=""
                class="d-flex justify-content-center align-items-center thumb-sm bg-soft-primary rounded-circle me-2">
                <i class="fab fa-facebook align-self-center"></i>
            </a>
            <a href=""
                class="d-flex justify-content-center align-items-center thumb-sm bg-soft-info rounded-circle me-2">
                <i class="fab fa-twitter align-self-center"></i>
            </a>
            <a href=""
                class="d-flex justify-content-center align-items-center thumb-sm bg-soft-danger rounded-circle">
                <i class="fab fa-google align-self-center"></i>
            </a>
        </div>
    </div>

</x-guest-layout>
