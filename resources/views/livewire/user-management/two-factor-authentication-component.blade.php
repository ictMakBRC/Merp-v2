<div>
    <div class="card mt-1 mt-lg-1 mb-5">
        <div class="card-body">
            <div class="border p-4 rounded">
                <div class="text-center mb-4">
                    <h3 class="">{{ __('Two Factor Authentication') }}</h3>
                    <span
                        class="d-block text-muted">{{ __('Please enter the Two Factor Authentication token/code to verify') }}</span>
                </div>
                <div class="form-body">
                    <form class="row g-3" wire:submit.prevent="verifyToken">
                        <div class="col-12 mt-2">
                            <input type="number" class="form-control" wire:model='token' id="token" required
                                autofocus autocomplete="off">
                        </div>

                        <div class="col-12">
                            <div class="d-grid">
                                <x-button class="btn-success">{{ __('Verify') }}</x-button>
                                <a href="#" class="btn btn-lg btn-light mt-2"
                                    wire:click='resendToken()'>{{ __('Resend Token') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
