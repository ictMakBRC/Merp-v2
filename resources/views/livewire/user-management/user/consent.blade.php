{{--   --}}
<div>
    <div class="card">
        <div class="card-header">
            <h6 class="mb-2 mt-3 text-primary">{{ __('Privacy and Data Sharing Consent Agreement') }}
            </h6>
            <p>
                Welcome to MERP.
                We are committed to safeguarding your privacy and ensuring the security of your personal information.
                Before you share sensitive data with us, it's important that you understand
                and consent to how we collect, use, and protect your information.
                This Privacy and Data Sharing Consent Agreement ("Agreement") outlines the terms
                and conditions of data sharing and processing.
                By providing your information, you are agreeing to the terms described below.
            </p>
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1 ms-3">
                    <h6 class="mt-2 text-success">{{ __('1. Data Collection:') }}</h6>
                    <p>We may collect personal information from you, including but not limited to your
                        full name, passport number, date of birth, and contact details.
                        This information is collected solely for the purpose of MERP Operations. We will only collect
                        the
                        minimum amount
                        of information necessary to fulfill this purpose.</p>
                </div>
            </div>
            <hr>
            <div class="d-flex align-items-center">
                <div class="flex-grow-1 ms-3">
                    <h6 class="mt-0 text-success">{{ __('2. Use of Information:') }}</h6>
                    <p>Your personal information will be used solely for the intended purpose stated above.
                        We will not share, sell, rent, or otherwise disclose your information to third parties without
                        your
                        explicit consent,
                        except as required by law or to fulfill the purpose of the data collection.</p>
                </div>
            </div>
            <hr>

            <div class="d-flex align-items-center">
                <div class="flex-grow-1 ms-3">
                    <h6 class="mt-0 text-success">{{ __('3. Data Security:') }}</h6>
                    <p>We take data security seriously.
                        We implement appropriate technical and organizational measures to protect your personal
                        information from unauthorized access, disclosure, alteration, or destruction.
                        Despite our efforts, no system can be entirely secure, and you share your information at your
                        own risk.
                    </p>
                </div>
            </div>
            <hr>

            <div class="d-flex align-items-center">
                <div class="flex-grow-1 ms-3">
                    <h6 class="mt-0 text-success">{{ __('4. Data Retention:') }}</h6>
                    <p>We will retain your personal information only for as
                        long as necessary to fulfill the purpose for which it was collected,
                        as required by law, or to establish, exercise, or defend legal claims.</p>
                </div>
            </div>
            <hr>

            <div class="d-flex align-items-center">
                <div class="flex-grow-1 ms-3">
                    <h6 class="mt-0 text-success">{{ __('5. Consent Withdrawal:') }}</h6>
                    <p>You have the right to withdraw your consent for the
                        collection and processing of your personal information at any time.
                        However, this may result in our inability to provide you with certain services or benefits.</p>
                </div>
            </div>
            <hr>

            <div class="d-flex align-items-center">
                <div class="flex-grow-1 ms-3">
                    <h6 class="mt-0 text-success">{{ __('5. Your Rights:') }}</h6>
                    <p>You have the right to access, and correct/update your personal information held by us.
                        You also have the right to lodge a complaint with the appropriate data protection authority.</p>
                </div>
            </div>
            <hr>
            <div class="d-flex align-items-center">
                <div class="flex-grow-1 ms-3">
                    <h6 class="mt-0 text-success">{{ __('6. International Data Transfer:') }}</h6>
                    <p>By providing your personal information, you understand and agree that your information may be
                        transferred to and processed in countries
                        outside of your own, where data protection laws may be different.</p>
                </div>
            </div>
            <hr>
            <div class="d-flex align-items-center">
                <div class="flex-grow-1 ms-3">
                    <h6 class="mt-0 text-success">{{ __('7. Changes to this Agreement:') }}</h6>
                    <p>We may update this Agreement from time to time to reflect changes in our practices or for legal,
                        operational, or regulatory reasons.
                        We will notify you of any material changes and obtain your renewed consent if required by
                        applicable
                        laws.</p>
                </div>
            </div>
            <hr>
            <div class="d-flex align-items-center">
                <div class="flex-grow-1 ms-3 text-primary fw-bold">
                    <p>By sharing your personal information with us, you acknowledge that you have read, understood, and
                        agreed
                        to the
                        terms outlined in this Privacy and Data Sharing Consent Agreement.</p>
                </div>
            </div>
            <div class="modal-footer">
                <x-button class="btn-success" wire:click='consent(1)'>{{ __('I Agree') }}</x-button>
                <x-button class="btn-danger" wire:click='consent(0)'>{{ __('I Decline') }}</x-button>

            </div>
        </div>

    </div>
    @push('scripts')
        <script>
            @if (Session::has('user_consent'))
                swal('Oops', "{{ session('user_consent') }}", 'info');
            @endif
        </script>
    @endpush
</div>
{{-- @endif --}}
