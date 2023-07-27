<x-guest-layout>
    <x-slot:title>
        {{ __('Forgot Password | NIMS') }}
        </x-slot>
        <!-- Password recovery form -->

        <div class="card-body p-0 auth-header-box">
            <div class="text-center p-3">
                <a href="{{ route('login') }}" class="logo logo-admin">
                    <img src="{{ asset('assets/images/logos/merp-logo.png') }}" height="50" alt="logo" class="auth-logo">
                </a>
                <h4 class="mt-3 mb-1 fw-semibold text-white font-18">{{ __('public.forgotpass') }}</h4>
                <p class="text-muted  mb-0">{{ __('public.forgot_pass_message') }}</p>
            </div>
        </div>
        <div class="card-body pt-3">
            <form class="row g-3" method="POST" action="{{ route('password.email') }}">
                @csrf
                @include('layouts.messages')
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <div class="form-group mb-3">
                    <label class="form-label" for="useremail">{{ __('public.email') }}</label>
                    <input type="text" class="form-control" id="useremail" name="email" value="{{ old('email') }}"
                        required autofocus autocomplete="off">
                </div>
                <!--end form-group-->

                <div class="form-group mb-0 row">
                    <div class="col-12">
                        <div class="d-grid">
                            <x-button class="btn-primary w-100">{{ __('public.sendlink') }}<i
                                    class="fas fa-sign-in-alt ms-1"></i></x-button>
                            <a href="{{ route('login') }}"
                                class="btn btn-lg btn-light mt-2">{{ __('public.backtologin') }}</a>
                        </div>
                    </div>
                </div>
                <!--end form-group-->
            </form>
            <!--end form-->
        </div>
        <!--end card-body-->

        <!-- /password recovery form -->
</x-guest-layout>
