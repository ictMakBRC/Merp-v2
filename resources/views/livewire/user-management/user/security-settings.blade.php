<div class="row" id="security">
    <div class="col-sm-12">
        <div class="card shadow-none border">
            <div class="card-header">
                <h6 class="mb-0 fw-bold"><i class="bx bx-shield-quarter me-2"></i>{{ __('user-mgt.security') }}</h6>
            </div>
            <div class="card-body">

                <div class="accordion accordion-flush" id="accordionSecurity">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-2fa">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-twoFactor" aria-expanded="false" aria-controls="flush-twoFactor">
                                {{ __('user-mgt.two_factor_auth') }} ( <strong class="text-success">2FA</strong>)
                            </button>
                        </h2>
                        <div id="flush-twoFactor" class="accordion-collapse collapse" aria-labelledby="flush-2fa"
                            data-bs-parent="#accordionSecurity">
                            <div class="accordion-body">
                                <ul class="list-group list-group-flush">
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-cente bg-transparent border-top">

                                        <div class="modal-footer">
                                            <strong>{{ __('Email 2FA') }}</strong>

                                            @if (auth()->user()->two_factor_auth_enabled && auth()->user()->two_factor_channel == 'email')
                                                <x-button class="btn btn-sm btn-outline-danger ms-3"
                                                    wire:click="disableTwoFactorAuthentication()">{{ __('public.disable') }}
                                                </x-button>
                                            @else
                                                <x-button class="btn btn-sm btn-outline-success ms-3"
                                                    wire:click="enableTwoFactorAuthentication('email')">
                                                    {{ __('public.enable') }}
                                                </x-button>
                                            @endif
                                        </div>
                                     

                                    </li>

                                    {{-- <li
                                        class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-top">
                                        <strong>{{ __('SMS/Whatsapp 2FA') }}</strong>
                                        @if (auth()->user()->two_factor_auth_enabled && auth()->user()->two_factor_channel == 'sms')
                                            <x-button class="btn-outline-danger"
                                                wire:click="disableTwoFactorAuthentication()">{{ __('public.disable') }}
                                            </x-button>
                                        @else
                                            <x-button class="btn-outline-success"
                                                wire:click="enableTwoFactorAuthentication('sms')" disabled>
                                                {{ __('public.enable') }}
                                            </x-button>
                                        @endif

                                    </li> --}}
                                </ul>

                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-changePassword">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-changePass" aria-expanded="false"
                                aria-controls="flush-changePass">
                                {{ __('public.changepass') }}
                            </button>
                        </h2>
                        <div id="flush-changePass" class="accordion-collapse collapse"
                            aria-labelledby="flush-changePassword" data-bs-parent="#accordionSecurity">
                            <div class="accordion-body">
                                @include('livewire.user-management.user.change-password')
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
