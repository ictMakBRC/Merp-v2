<div x-cloak x-show="create_new">
    <form  @if ($toggleForm) wire:submit.prevent="updateCustomer" @else wire:submit.prevent="storeCustomer" @endif >             

        <div class="row">  
            
            <div class="mb-3 col-md-2">
                <label for="type" class="form-label required">Type</label>
                <select class="form-select select2" id="nationality" wire:model.lazy='type'>
                    <option selected value="">Select</option>
                    <option value="Customer">Customer</option>
                    <option value="Sponsor">Sponsor</option>
                    <option value="Funder">Funder</option>
                </select>
                @error('type')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="name" class="form-label required">{{ $type }} Name</label>
                <input type="text" id="name" class="form-control"wire:model.defer='name'>
                @error('name')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="name" class="form-label required">{{ $type }} Short Code</label>
                <input type="text" id="name" class="form-control text-uppercase"
                    onkeyup="this.value = this.value.toUpperCase();" wire:model.defer='code'>
                @error('code')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="nationality" class="form-label">Donor</label>
                <select class="form-select select2" id="parent_id" wire:model.lazy='parent_id'>
                    <option selected value="">Select</option>
                    @foreach ($funders as $funder)
                        <option value="{{ $funder->id }}">{{ $funder->name }}</option>
                    @endforeach
                </select>
                @error('parent_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="nationality" class="form-label required">Nationality</label>
                <select class="form-select select2" id="nationality" wire:model.lazy='nationality'>
                    <option selected value="">Select</option>
                    @include('layouts.nationalities')
                </select>
                @error('nationality')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="address" class="form-label">Address</label>
                <input type="text" id="address" class="form-control text-uppercase" wire:model.defer='address'
                    onkeyup="this.value = this.value.toUpperCase();">
                @error('address')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="email" class="form-label required">Email Address</label>
                <input type="email" id="email" class="form-control" wire:model.defer='email'>
                @error('email')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="alt_email" class="form-label">Alternative Email</label>
                <input type="email" id="alt_email" class="form-control" wire:model.defer='alt_email'>
                @error('alt_email')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="contact" class="form-label required">Telephone Number</label>
                <input type="text" id="contact" class="form-control text-uppercase"
                    onkeyup="this.value = this.value.toUpperCase();" wire:model.defer='contact'>
                @error('contact')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="v" class="form-label">Company Name</label>
                <input type="text" id="company_name" class="form-control text-uppercase"
                    wire:model.defer='company_name'>
                @error('city')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="city" class="form-label">City</label>
                <input type="text" id="city" class="form-control text-uppercase"
                    wire:model.defer='city'>
                @error('city')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="fax" class="form-label">Fax</label>
                <input type="tel" id="fax" class="form-control text-uppercase"
                    wire:model.defer='fax'>
                @error('fax')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-md-2">
                <label for="city" class="form-label">Website</label>
                <input type="website" id="website" class="form-control text-uppercase"
                    wire:model.defer='website'>
                @error('website')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="sales_tax_registration" class="form-label">TIN Number</label>
                <input type="number" id="sales_tax_registration" class="form-control" wire:model.defer='sales_tax_registration'>
                @error('sales_tax_registration')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-md-2">
                <label for="currency_id" class="form-label">Currency</label>
                <select class="form-select select2" id="currency_id" wire:model='currency_id'>
                    <option value="">Select</option>
                    @foreach ($currencies as $currency)
                        <option value='{{ $currency->id }}'>{{ $currency->code }}</option>
                    @endforeach
                </select>
                @error('currency_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            
                        
            <div class="mb-3 col">
                <label for="opening_balance" class="form-label required">As of</label>
                <input type="date" id="as_of" class="form-control" wire:model='as_of'>
                @error('as_of')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col">
                <label for="is_active" class="form-label required">{{ __('public.status') }}</label>
                <select class="form-select select2" id="is_active" wire:model.defer="is_active">
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
            <x-button class="btn btn-success">{{ __('public.save') }}</x-button>
        </div>
        <hr>
    </form>
    <hr>
</div>
