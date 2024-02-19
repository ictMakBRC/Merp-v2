<div x-cloak x-show="create_new">
    <form wire:submit.prevent>
        <div class="row">
            <div class="row col-md-5">
                <div class="mb-2 col-md-12">
                    <label for="category" class="form-label required">{{ __('user-mgt.user_category') }} </label>
                    <select class="form-select select2" id="category" wire:model.lazy="category">
                        <option selected value="">Select</option>
                        <option value='Normal-User'>Normal User</option>
                        <option value='Funder'>Project/Study Funder</option>
                        <option value='External-Monitor'>External Monitor</option>
                        <option value='System-Admin'>System Admin</option>
                        <option value='External-Application'>External Application</option>
                    </select>
                    @error('category')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>
                @if ($category != '')
                    @if ($category == 'Normal-User' && !$toggleForm )
                        <div class="mb-2 col-md-12">
                            <label for="employee_number" class="form-label required">{{ __('Employee No') }} </label>
                            <input type="text" id="employee_number" class="form-control"
                                wire:model.lazy="employee_number">
                            @if ($employee_number != '' && $employee_matched)
                                <div class="text-success text-small">{{ __('Employee Matched') }}</div>
                            @elseif($employee_number != '' && !$employee_matched)
                                <div class="text-danger text-small">{{ __('Employee Match not found') }}</div>
                            @endif

                            @error('employee_number')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                    <div class="mb-2 col-md-12">
                        <label for="name" class="form-label required">{{ __('public.name') }} </label>
                        <input type="text" id="name" class="form-control" wire:model.defer="name">
                        @error('name')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-2 col-md-12">
                        <label for="userEmail" class="form-label required">{{ __('public.email_address') }}</label>
                        <input type="email" id="userEmail" class="form-control" wire:model.defer="email">
                        @error('email')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-2 col-md-12">
                        <label for="contact" class="form-label required">{{ __('public.contact') }}</label>
                        <input type="text" id="contact" class="form-control" wire:model.defer="contact">
                        @error('contact')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    @if ($category != 'External-Application')
                        <div class="mb-2 col-md-12">
                            <label for="signature" class="form-label">Signature</label>
                            <input type="file" id="signature" class="form-control" wire:model.defer="signature">
                            <div class="text-primary text-small" wire:loading wire:target="signature">Uploading
                                signature
                            </div>
                            @error('signature')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    @if (!$toggleForm)
                        <div class="mb-2 col-md-6">
                            <label for="password" class="form-label">{{ __('public.password') }}</label>
                            <input type="text" id="password" class="form-control" placeholder="Auto-Generated"
                                wire:model="password" readonly>
                            @error('password')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    <div class="mb-2 col-md-6">
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

                @endif
            </div>

            @if ($category != 'External-Application')
                <div class="col-md-3 bg-light">
                    <h6>User roles</h4>
                    <div class="scrollable-div">
                        @error('user_roles')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                        <div class="list-group list-group-flush">
                            @forelse ($roles as $role)
                                <div class="form-check list-group-item py-1 ms-2">
                                    <input class="form-check-input" type="checkbox" value="{{ $role->id }}"
                                        id="role{{ $role->id }}" wire:model="user_roles">
                                    <label class="form-check-label"
                                        for="role{{ $role->id }}">{{ $role->display_name }}</label>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif

            @if ($category == 'Funder')
                <div class="col-md-4 bg-light">
                    <h6>Funder's Projects/Studies</h4>
                    <div class="scrollable-div">
                        @error('user_roles')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                        <div class="list-group list-group-flush">
                            @forelse ($projects as $project)
                                <div class="form-check list-group-item py-1 ms-2">
                                    <input class="form-check-input" type="checkbox" value="{{ $project->id }}"
                                        id="project{{ $project->id }}" wire:model="funder_projects">
                                    <label class="form-check-label"
                                        for="project{{ $project->id }}">{{ $project->project_code }}</label>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif

            @if ($category == 'External-Monitor')
                <div class="col-md-3 bg-light">
                    <h6>Monitored Departments/Labs</h4>
                    <div class="scrollable-div">
                        @error('monitored_departments')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                        <div class="list-group list-group-flush">
                            @forelse ($departments as $department)
                                <div class="form-check list-group-item py-1 ms-2">
                                    <input class="form-check-input" type="checkbox" value="{{ $department->id }}"
                                        id="department{{ $department->id }}" wire:model="monitored_departments">
                                    <label class="form-check-label"
                                        for="department{{ $department->id }}">{{ $department->name }}</label>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif
        </div>


        <div class="modal-footer">
            @if ($token)
                <div class="input-group mb-3">
                    <input type="text" id="token" class="form-control" wire:model="token" readonly>
                    <button class="btn btn-outline-primary" type="button" onclick="copyText()"
                        wire:click='resetToken()' title="Copy Token"><i class="bx bx-clipboard"></i></button>
                </div>
            @endif

            @if ($category == 'External-Application')
                <div class="ms-0 alert border-0 border-start border-5 border-info alert-dismissible fade show py-2">
                    <div class="d-flex align-items-center">
                        <div class="font-35 text-info"><i class='bx bx-info-circle'></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-info fw-bold">
                                {{ __('Please use the details of the institution to which the external application belongs
                                                                                                                                                                                                                                                            to fill the email field') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (!$toggleForm)
                @if ($category == 'External-Application')
                    <div class="form-check  py-1 ms-2 px-2">
                        <input class="form-check-input" type="checkbox" id="generateToken" checked
                            wire:model="generateToken">
                        <label class="form-check-label text-primary fw-bold"
                            for="generateToken">{{ __('Generate API Token') }}</label>
                    </div>
                @endif
                <x-button class="btn-primary" wire:click='storeUser'>{{ __('public.save') }}</x-button>
            @else
                <x-button class="btn-primary" wire:click='updateUser'>{{ __('public.update') }}</x-button>
            @endif
        </div>

    </form>
    <hr>
</div>
