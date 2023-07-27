<x-guest-layout>
    <x-slot:title>
        {{ __('Reset Password | NIMS') }}
        </x-slot>



        <div class="card-body p-0 auth-header-box">
            <div class="text-center p-3">
                <a href="{{ route('login') }}" class="logo logo-admin">
                    <img src="{{ asset('assets/images/logos/merp-logo.png') }}" height="50" alt="logo"
                        class="auth-logo">
                </a>
                <h4 class="mt-3 mb-1 fw-semibold text-white font-18">{{ __('public.createnewpass') }}</h4>
                <p class="text-muted  mb-0">{{ __('public.reset_pass_message') }}</p>
            </div>
        </div>
        <div class="card-body pt-3">
            <form class="row g-3" method="POST" action="{{ route('password.store') }}">
                @csrf
                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                @include('layouts.messages')
                <div class="col-12">
                    <x-label for="inputEmailAddress">{{ __('public.email') }}</x-label>
                    <input type="email" class="form-control" id="inputEmailAddress" name="email"
                        value="{{ old('email', $request->email) }}" required>
                </div>
                <div class="col-12">
                    <x-label for="inputChoosePassword">
                        {{ __('public.newpassword') }}</x-label>
                    <div class="input-group" id="show_hide_password">
                        <input type="password" class="form-control border-end-1" id="inputNewPassword"
                            placeholder="Enter New Password" name="password" required autofocus>
                    </div>
                </div>
                <div class="col-12">
                    <x-label for="inputChoosePassword">
                        {{ __('public.confirmpass') }}</x-label>
                    <div class="input-group" id="show_hide_password2">
                        <input type="password" class="form-control border-end-0" id="inputConfirmPassword"
                            placeholder="Confirm Password" name="password_confirmation" required> <a href="javascript:;"
                            class="input-group-text bg-transparent"></a>
                    </div>
                </div>

                <div class="col-12">
                    <div class="d-grid">
                        <x-button class="btn-primary">{{ __('Change Password') }}</x-button>
                    </div>
                </div>
            </form>
        </div>
        <!--end card-body-->
</x-guest-layout>
