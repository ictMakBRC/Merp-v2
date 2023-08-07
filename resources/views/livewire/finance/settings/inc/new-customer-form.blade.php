<div x-cloak x-show="create_new">
    <form  @if ($toggleForm) wire:submit.prevent="updateCustomer" @else wire:submit.prevent="storeCustomer" @endif >             

        <div class="row">

            <div class="mb-3 col">
                <label for="title" class="form-label required">Title</label>
                <select class="form-select select2" id="title" wire:model.defer='title'>
                    <option selected value="">Select</option>
                    <option value="Mr.">Mr.</option>
                    <option value="Ms.">Ms.</option>
                    <option value="Miss.">Miss.</option>
                    <option value="Dr.">Dr.</option>
                    <option value="Eng.">Eng.</option>
                    <option value="Prof.">Prof.</option>
                </select>
                @error('title')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col">
                <label for="gender" class="form-label required">Gender</label>
                <select class="form-select select2" id="gender" wire:model.lazy='gender'>
                    <option selected value="">Select</option>
                    <option value='Male'>Male</option>
                    <option value='Female'>Female</option>
                    <option value='Other'>Other</option>
                </select>
                @error('gender')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="surname" class="form-label required">Surname</label>
                <input type="text" id="surname" class="form-control text-uppercase"
                    onkeyup="this.value = this.value.toUpperCase();" wire:model.defer='surname'>
                @error('surname')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="first_name" class="form-label required">First Name</label>
                <input type="text" id="first_name" class="form-control text-uppercase"
                    onkeyup="this.value = this.value.toUpperCase();" wire:model.defer='first_name'>
                @error('first_name')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="other_name" class="form-label">Other Name</label>
                <input type="text" id="other_name" class="form-control text-uppercase"
                    onkeyup="this.value = this.value.toUpperCase();" wire:model.defer='other_name'>
                @error('other_name')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="nationality" class="form-label required">Origin</label>
                <select class="form-select select2" id="nationality" wire:model.lazy='nationality'>
                    <option selected value="">Select</option>
                    @include('layouts.nationalities')
                </select>
                @error('nationality')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" id="address" class="form-control text-uppercase" wire:model.defer='address'
                    onkeyup="this.value = this.value.toUpperCase();">
                @error('address')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="email" class="form-label required">Email Address</label>
                <input type="email" id="email" class="form-control" wire:model.defer='email'>
                @error('email')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="alt_email" class="form-label">Alternative Email</label>
                <input type="email" id="alt_email" class="form-control" wire:model.defer='alt_email'>
                @error('alt_email')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="contact" class="form-label required">Telephone Number</label>
                <input type="text" id="contact" class="form-control text-uppercase"
                    onkeyup="this.value = this.value.toUpperCase();" wire:model.defer='contact'>
                @error('contact')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="v" class="form-label">Company Name</label>
                <input type="text" id="company_name" class="form-control text-uppercase"
                    wire:model.defer='company_name'>
                @error('city')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="city" class="form-label">City</label>
                <input type="text" id="city" class="form-control text-uppercase"
                    wire:model.defer='city'>
                @error('city')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="fax" class="form-label">Fax</label>
                <input type="tel" id="fax" class="form-control text-uppercase"
                    wire:model.defer='fax'>
                @error('fax')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-md-3">
                <label for="city" class="form-label">Website</label>
                <input type="website" id="website" class="form-control text-uppercase"
                    wire:model.defer='website'>
                @error('website')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            {{-- <div class="mb-3 col-md-4">
                <label for="reporting_to" class="form-label">Reporting to</label>
                <select class="form-select select2" id="reporting_to" wire:model.defer='reporting_to'>
                    <option selected value="">Select</option>
                    @foreach ($supervisors as $employee)
                        <option value='{{ $employee->id }}'>{{ $employee->fullName }}</option>
                    @endforeach
                </select>
                @error('reporting_to')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div> --}}
            <div class="mb-3 col-md-3">
                <label for="sales_tax_registration" class="form-label">TIN Number</label>
                <input type="number" id="sales_tax_registration" class="form-control" wire:model.defer='sales_tax_registration'>
                @error('sales_tax_registration')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="opening_balance" class="form-label">Social Security Number</label>
                <input type="text" id="opening_balance" class="form-control text-uppercase"
                    onkeyup="this.value = this.value.toUpperCase();" wire:model.defer='opening_balance'>
                @error('opening_balance')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3 col-md-3">
                <label for="opening_balance" class="form-label required">Opening Balance</label>
                <input type="number" step='any' id="opening_balance" class="form-control" wire:model.defer='opening_balance'>
                @error('opening_balance')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3 col-md-3">
                <label for="opening_balance" class="form-label required">As of</label>
                <input type="date" id="as_of" class="form-control" wire:model.defer='as_of'>
                @error('as_of')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

        </div>
        <div class="modal-footer">
            <x-button class="btn btn-success">{{ __('public.save') }}</x-button>
        </div>
        <hr>
    </form>
    <hr>
</div>
