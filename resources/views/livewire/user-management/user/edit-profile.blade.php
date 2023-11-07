<div class="col-12 col-lg-8">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="mb-0">{{__('user-mgt.my_account')}}</h5>
            <hr>
            <div class="card shadow-none border">
                <div class="card-header">
                    <h6 class="mb-0">{{__('user-mgt.update_information')}}</h6>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="updateUser">

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label required">{{__('public.name')}}</label>
                                <input type="text" id="name" class="form-control" wire:model.lazy="name">
                                @error('name')
                                <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="userEmail"
                                    class="form-label required">{{__('public.email_address')}}</label>
                                <input type="email" id="userEmail" class="form-control" wire:model.lazy="email">
                                @error('email')
                                <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col">
                                <label for="avatar" class="form-label">{{__('public.photo')}} (<strong
                                        class="text-danger">1Mb</strong> Maximum)</label>
                                <input type="file" id="avatar{{ $dynamicID }}" class="form-control" wire:model="avatar">
                                <div class="text-primary text-small" wire:loading wire:target="avatar">Uploading
                                    photo...</div>
                                @error('avatar')
                                <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col">
                                <label for="avatar" class="form-label">{{__('public.signature')}} (<strong
                                        class="text-danger">1Mb</strong> Maximum)</label>
                                <input type="file" id="signature{{ $dynamicID }}" class="form-control" wire:model="signature">
                                <div class="text-primary text-small" wire:loading wire:target="signature">Uploading
                                    photo...</div>
                                @error('signature')
                                <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            @if ($allow_update)
                            <div class="mb-3 col-md-4">
                                <label for="current_password"
                                    class="form-label required text-primary fw-bold">{{__('public.currentpass')}}</label>
                                <input type="password" id="current_password" class="form-control"
                                    wire:model.defer="current_password" autocomplete="off"
                                    placeholder="Enter current password to update">
                                @error('current_password')
                                <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            @endif

                        </div>
                        <!-- end row-->
                        @if ($allow_update)
                        <div class="modal-footer">
                            <x-button class="btn-primary">{{ __('public.update') }}</x-button>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
            @include('livewire.user-management.user.security-settings')
            {{-- @include('livewire.user-management.user.general-settings') --}}
        </div>
    </div>
</div>