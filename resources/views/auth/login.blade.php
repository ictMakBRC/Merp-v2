
<x-guest-layout>
    <x-slot:title>
        {{ __('Login | NIMS') }}
        </x-slot>
        <div class="card mt-1 mt-lg-1 mb-5">
            <div class="card-body">
                <div class="border p-4 rounded">
                    <div class="text-center">
                        <h5 class="text-success">{{ __('public.pgi') }}</h5>
                        <h6 class="text-primary">Network Information Management System (NIMS)</h6>
                        <hr>
                    </div>
                    <div class="form-body">
                        <form method="POST" action="{{ route('login-guest') }}" class="row g-3">
                            @csrf
                            @include('layouts.messages')
                            <div class="col-12">
                                <x-label for="inputEmailAddress">{{ __('public.email') }}</x-label>
                                <input type="email" class="form-control" id="inputEmailAddress"
                                    placeholder="Email Address" required name="email" value="{{ old('email') }}" autocomplete="off">
                            </div>
                            <div class="col-12">
                                <x-label for="inputChoosePassword">
                                    {{ __('public.password') }}</x-label>
                                <div class="input-group" id="show_hide_password">
                                    <input type="password" class="form-control border-end-1" id="inputChoosePassword"
                                        placeholder="Enter Password" name="password" required> 
                                        {{-- <a href="javascript:;"
                                        class="input-group-text bg-transparent" autocomplete="off">
                                        <i class='bx bx-hide'></i>
                                    </a> --}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{-- <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked"
                                        name="remember">
                                    <x-label class="form-check-label" for="flexSwitchCheckChecked">
                                        {{ __('public.rememberme') }}</x-label>
                                </div> --}}
                            </div>
                            <div class="col-md-6 text-end">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">{{ __('public.forgotpass') }}</a>
                                @endif
                            </div>
                            <div class="col-12">
                                <div class="d-grid">
                                    <x-button class="btn-success">{{ __('public.login') }}</x-button>
                                </div>
                            </div>

                            {{-- <div class="col-12 text-center">
                                <div class="d-grid">
                                    <h6 class="text-success">Or</h6>
                                    <a href="{{ route('network-map') }}"
                                        class="btn btn-lg btn-light mt-2">{{ __('public.read_more') }}</a>
                                </div>
                            </div> --}}
                        </form>
                       
                    </div>
                </div>

                <div class="text-center">
                    <div class="d-inline-flex align-items-center justify-content-center mb-1 mt-0">
                        <strong class="text-success">{{ __('public.new_to_nims') }}</strong> <a class="nav-link active"
                        href="{{ route('network-map') }}"><i
                            class='bx bx-info-circle me-1'></i>{{ __('public.read_more') }}</a>
                    </div>
                </div>
            </div>
        </div>
        @push('scripts')
                <!--Password show & hide js -->
            {{-- <script>
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
            </script> --}}
        @endpush
</x-guest-layout>
