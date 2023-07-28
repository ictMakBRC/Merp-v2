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
                            {{-- <div class="mb-3 col-md-4">
                                <label for="title" class="form-label required">{{__('public.title')}}</label>
                                <select class="form-select" id="title" wire:model.lazy="title" @if ($no_edit) disabled @endif>
                                    <option value="" selected>Select</option>
                                    <option value="Mr">Mr</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Ms">Ms</option>
                                    <option value="Miss">Miss</option>
                                    <option value="Dr">Dr</option>
                                    <option value="Eng">Eng</option>
                                    <option value="Prof">Prof</option>
                                </select>
                                @error('title')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div> --}}

                            <div class="mb-3 col-md-4">
                                <label for="surname" class="form-label required">{{__('public.surname')}}</label>
                                <input type="text" id="surname" class="form-control"
                                    wire:model.lazy="surname" @if ($no_edit) disabled @endif>
                                @error('surname')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="first_name" class="form-label required">{{__('public.first_name')}}</label>
                                <input type="text" id="first_name" class="form-control"
                                    wire:model.lazy="first_name" @if ($no_edit) disabled @endif>
                                @error('first_name')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="other_name" class="form-label">{{__('public.other_name')}}</label>
                                <input type="text" id="other_name" class="form-control"
                                    wire:model.lazy="other_name" @if ($no_edit) disabled @endif>
                                @error('other_name')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="usercontact" class="form-label required">{{__('public.contact')}}</label>
                                <div class="input-group">
                                    @include('layouts.country-codes')
                                    <input type="number" id="usercontact" class="form-control"
                                    wire:model.lazy="contact" @if ($no_edit) disabled @endif placeholder="{{ __('public.contact') }}" step="1">
                                </div>

                                @error('phone_code')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                                @error('contact')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="userEmail" class="form-label required">{{__('public.email_address')}}</label>
                                <input type="email" id="userEmail" class="form-control" wire:model.lazy="email" @if ($no_edit) disabled @endif>
                                @error('email')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="avatar" class="form-label">{{__('public.photo')}} (<strong class="text-danger">1Mb</strong> Maximum)</label>
                                <input type="file" id="avatar" class="form-control" wire:model="avatar">
                                <div class="text-success text-small" wire:loading wire:target="avatar">Uploading photo...</div>
                                @error('avatar')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            @if ($allow_update)
                            <div class="mb-3 col-md-6">
                                <label for="current_password" class="form-label required text-success fw-bold">{{__('public.currentpass')}}</label>
                                <input type="password" id="current_password" class="form-control"
                                    wire:model.defer="current_password" autocomplete="off" placeholder="Enter current password to update">
                                @error('current_password')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            @endif
                           
                        </div>
                        <!-- end row-->
                        @if ($allow_update)
                        <div class="modal-footer">
                            <x-button class="btn-success">{{ __('public.update') }}</x-button>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
            @include('livewire.user-management.user.security-settings')
            @include('livewire.user-management.user.general-settings')
        </div>
    </div>
</div>