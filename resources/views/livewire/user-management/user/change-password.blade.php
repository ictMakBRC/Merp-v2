<div>
    <div class="card-header text-center">
        <p class="mb-0">(<span class="text-primary">{{__('public.lastchangedat')}} </span><span
                class="text-success">@formatDateTime($user->password_updated_at)</span>) Exipres in {{now()->diffInDays(\Carbon\Carbon::parse($user->password_updated_at)->addDays(config('auth.password_expires_days')))}} days</p>
    </div>
        <form wire:submit.prevent="changePassword">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">{{__('public.currentpass')}}</label>
                        <input type="password" id="current_password" class="form-control"
                            wire:model.defer="current_password" autocomplete="off">
                        @error('current_password')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">{{__('public.newpassword')}}</label>
                        <input type="password" id="password" class="form-control"
                            wire:model.defer="password" autocomplete="off">
                        @error('password')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">{{__('public.confirmpass')}}</label>
                        <input type="password" id="password_confirmation" class="form-control"
                            wire:model.defer="password_confirmation" autocomplete="off">
                        @error('password_confirmation')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>
            <!-- end row-->
            <div class="modal-footer">
                <x-button class="btn-success">{{__('public.changepass')}}</x-button>
            </div>
        </form>
</div>