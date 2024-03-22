<div>
    @include('livewire.human-resource.employee-data.inc.loading-info')

    <form
        @if (!$toggleForm) wire:submit.prevent="storeFamilyInformation"
    @else
    wire:submit.prevent="updateFamilyInformation" @endif>
        <div class="row">
            <div class="mb-3 col-md-3">
                <label for="member_type" class="form-label required">Member Type</label>
                <select class="form-select select2" id="member_type" wire:model="member_type" required>
                    <option selected value="">Select</option>
                    <option value='Spouse'>Spouse</option>
                    <option value='Father'>Father</option>
                    <option value='Mother'>Mother</option>
                    <option value='Brother'>Brother</option>
                    <option value='Sister'>Sister</option>
                    <option value='Son'>Son</option>
                    <option value='Daughter'>Daughter</option>
                </select>
                @error('member_type')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="surname" class="form-label required">Surname</label>
                <input type="text" id="surname" class="form-control" wire:model.defer="surname" required>
                @error('surname')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="first_name" class="form-label required">First Name</label>
                <input wire:model.defer="first_name" type="text" id="first_name" class="form-control" required>
                @error('first_name')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="other_name" class="form-label">Other Name</label>
                <input wire:model.defer="other_name" type="text" id="other_name" class="form-control">
                @error('other_name')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="member_status" class="form-label required">Status</label>
                <select class="form-select select2" id="member_status" wire:model.defer="member_status" required>
                    <option selected value="">Select</option>
                    <option value='Alive'>Alive</option>
                    <option value='Deceased'>Deceased</option>
                </select>
                @error('member_status')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="address" class="form-label">Address</label>
                <input wire:model.defer="address" type="text" id="address" class="form-control">
                @error('address')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="contact" class="form-label">Contact</label>
                <input wire:model.defer="contact" type="text" id="contact" class="form-control">
                @error('contact')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="occupation" class="form-label">Occupation</label>
                <input wire:model.defer="occupation" type="text" id="occupation" class="form-control">
                @error('occupation')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="employer" class="form-label">Employer/Business Name</label>
                <input wire:model.defer="employer" type="text" id="employer" class="form-control">
                @error('employer')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="employer_contact" class="form-label">Employer/Business Contact</label>
                <input wire:model.defer="employer_contact" type="text" id="employer_contact" class="form-control">
                @error('employer_contact')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="employer_address" class="form-label">Employer/Business Address</label>
                <input wire:model.defer="employer_address" type="text" id="employer_address" class="form-control">
                @error('employer_address')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="modal-footer">
            <x-button class="btn btn-success">
                @if (!$toggleForm)
                    {{ __('public.save') }}
                @else
                    {{ __('public.update') }}
                @endif
            </x-button>
        </div>
        <hr>
    </form>
    <!--FAMILY BACKGROUND INFORMATION-->
    @if (!$familyInformation->isEmpty())
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-striped w-100 mb-0">
                        <thead>
                            <tr>

                                <th>Member</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Contact</th>
                                <th>Occupation</th>
                                <th>Employer</th>
                                <th>Employer-Address</th>
                                <th>Employer-Contact</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @foreach ($familyInformation as $familybackground)
                            <tr>
                                <td>
                                    {{ $familybackground->member_type }}

                                </td>
                                <td>
                                    {{ $familybackground->fullName }}
                                </td>
                                <td>
                                    {{ $familybackground->address ?? 'N/A' }}

                                </td>
                                <td>
                                    {{ $familybackground->contact ?? 'N/A' }}
                                </td>
                                <td>
                                    {{ $familybackground->occupation ?? 'N/A' }}
                                </td>
                                <td>
                                    {{ $familybackground->employer ?? 'N/A' }}
                                </td>
                                <td>
                                    {{ $familybackground->employer_address ?? 'N/A' }}
                                </td>
                                <td>
                                    {{ $familybackground->employer_contact ?? 'N/A' }}
                                </td>
                                @if ($familybackground->member_status == 'Alive')
                                    <td><span class="badge bg-success">Alive</span></td>
                                @else
                                    <td><span class="badge bg-danger">Deceased</span></td>
                                @endif
                                <td>
                                    <button class="btn btn btn-sm btn-outline-success"
                                        wire:click="editData({{ $familybackground->id }})"
                                        title="{{ __('public.edit') }}">
                                        <i class="ti ti-edit fs-18"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div> <!-- end preview-->
            </div>
        </div>
        <!-- end FAMILY BACKGROUND-->
    @endif

</div>
