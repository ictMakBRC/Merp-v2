<div>
    @include('livewire.human-resource.employee-data.inc.loading-info')

    <form wire:submit.prevent="storeFamilyInformation">
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
            <x-button class="btn-success">{{__('public.save')}}</x-button>
        </div>
        <hr>
    </form>

    {{-- <div class="row pt-3">
        <div class="col-12">
            <div class="card-header pt-0">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <div class="text-sm-end mt-3">
                            <h4 class="header-title mb-3  text-center">Children/Dependants</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="mb-3 col-md-5">
                            <label for="child_name" class="form-label required">Name of Child</label>
                            <input type="text" id="child_name" class="form-control" wire:model.defer="child_name"
                                required>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="birth_date" class="form-label required">Birth Date</label>
                            <input type="date" id="birth_date" class="form-control" wire:model.defer="birth_date"
                                required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <x-button class="btn-success">{{__('public.save')}}</x-button>
                    </div>
                </form>
            </div> <!-- end card body-->
        </div><!-- end col-->
    </div> --}}

</div>
