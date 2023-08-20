<div x-cloak x-show="create_new">
    <form wire:submit.prevent>
        <div class="row">
            <div class="mb-3 col-md-3">
                <label for="category" class="form-label required">{{ __('user-mgt.user_category') }} </label>
                <select class="form-select select2" id="category" wire:model.lazy="category">
                    <option selected value="">Select</option>
                    <option value='Normal-User'>Normal User</option>
                    <option value='System-Admin'>System Admin</option>
                    <option value='External-Application'>External Application</option>
                </select>
                @error('category')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="name" class="form-label required">{{ __('public.name') }} </label>
                <input type="text" id="name" class="form-control" wire:model.defer="name">
                @error('name')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3 col-md-5">
                <label for="userEmail" class="form-label required">{{ __('public.email_address') }}</label>
                <input type="email" id="userEmail" class="form-control" wire:model.defer="email">
                @error('email')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            @if ($category != 'External-Application')
                <div class="mb-3 col-md-4">
                    <label for="signature" class="form-label">Signature</label>
                    <input type="file" id="signature" class="form-control" wire:model.defer="signature">
                    <div class="text-success text-small" wire:loading wire:target="signature">Uploading signature
                    </div>
                    @error('signature')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            @if (!$toggleForm)
                <div class="mb-3 col-md-2">
                    <label for="password" class="form-label">{{ __('public.password') }}</label>
                    <input type="text" id="password" class="form-control" placeholder="Auto-Generated"
                        wire:model="password">
                    @error('password')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>

                @if ($category != 'External-Application')
                    <div class="mb-3 col-md-6">
                        <label for="roles" class="form-label">{{ __('user-mgt.roles') }}
                        </label>
                        <select id='roles' wire:model.lazy="role_id" class="form-select select2">
                            <option selected value="">Select</option>
                            @foreach ($roles as $role)
                                <option value='{{ $role->id }}'>{{ $role->display_name }}</option>
                            @endforeach
                        </select>
                        @error('roles_array')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                @endif
            @endif
            <div class="mb-3 col-md-2">
                <label for="is_active" class="form-label required">{{ __('public.status') }}</label>
                <select class="form-select select2" id="is_active" wire:model.lazy="is_active">
                    <option selected value="">Select</option>
                    <option value='1'>Active</option>
                    <option value='0'>Inactive</option>
                </select>
                @error('is_active')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="modal-footer">
            @if ($token)
                <div class="input-group mb-3">
                    <input type="text" id="token" class="form-control" wire:model="token" readonly>
                    <button class="btn btn-outline-success" type="button" onclick="copyText()"
                        wire:click='resetToken()' title="Copy Token"><i class="bx bx-clipboard"></i></button>
                </div>
            @endif

            @if ($category == 'External-Application')
                <div class="ms-0 alert border-0 border-start border-5 border-info alert-dismissible fade show py-2">
                    <div class="d-flex align-items-center">
                        <div class="font-35 text-info"><i class='bx bx-info-circle'></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-danger">
                                {{ __('Please use the details of the institution to which the external application belongs to fill the email field') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (!$toggleForm)
                @if ($category == 'External-Application')
                    <div class="form-check  py-1 ms-2">
                        <input class="form-check-input" type="checkbox" id="generateToken" checked
                            wire:model="generateToken">
                        <label class="form-check-label text-primary fw-bold"
                            for="generateToken">{{ __('Generate API Token') }}</label>
                    </div>
                @endif
                <x-button class="btn-success" wire:click='storeUser'>{{ __('public.save') }}</x-button>
            @else
                <x-button class="btn-success" wire:click='updateUser'>{{ __('public.update') }}</x-button>
            @endif
        </div>
    </form>
    <hr>
</div>
