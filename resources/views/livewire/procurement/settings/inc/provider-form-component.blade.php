

<div>
    <div class="card-bod p-0" x-cloak x-show="create_new">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#general-information" role="tab"
                    aria-selected="true">General Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#sector" role="tab"
                    aria-selected="false">Sector</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#documents" role="tab"
                    aria-selected="false">Documents</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane p-3 active" id="general-information" role="tabpanel">
                <form wire:submit.prevent="storeProvider">
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label for="name" class="form-label required">{{ __('Name') }}</label>
                            <input type="text" id="name" class="form-control" wire:model.defer="name">
                            @error('name')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="mb-3 col-md-4">
                            <label for="provider_type" class="form-label required">{{ __('Provider Type') }}</label>
                            <select class="form-select" id="provider_type" wire:model.lazy="provider_type">
                                <option selected value="">Select</option>
                                <option value="primary">Primary Supplier</option>
                                <option value="secondary">Secondary Supplier</option>
                                <option value="strategic">Strategic Supplier</option>
                                <option value="vendor">Vendor</option>
                                <option value="partner">Partner Supplier</option>
                                <option value="local">Local Supplier</option>
                                <option value="international">International Supplier</option>
                            </select>
                            @error('provider_type')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="mb-3 col-md-4">
                            <label for="phone_number" class="form-label required">{{ __('Telephone') }}</label>
                            <input type="text" id="phone_number" class="form-control" wire:model.defer="phone_number">
                            @error('phone_number')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="mb-3 col-md-4">
                            <label for="alt_phone_number" class="form-label">{{ __('Alternative Telephone') }}</label>
                            <input type="text" id="alt_phone_number" class="form-control" wire:model.defer="alt_phone_number">
                            @error('alt_phone_number')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="mb-3 col-md-4">
                            <label for="email" class="form-label required">{{ __('Email') }}</label>
                            <input type="email" id="email" class="form-control" wire:model.defer="email">
                            @error('email')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="mb-3 col-md-4">
                            <label for="alt_email" class="form-label">{{ __('Alternative Email') }}</label>
                            <input type="email" id="alt_email" class="form-control" wire:model.defer="alt_email">
                            @error('alt_email')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="mb-3 col-md-4">
                            <label for="full_address" class="form-label required">{{ __('Full Address') }}</label>
                            <textarea id="full_address" class="form-control" wire:model.defer="full_address"></textarea>
                            @error('full_address')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="mb-3 col-md-4">
                            <label for="contact_person" class="form-label required">{{ __('Contact Person Name') }}</label>
                            <input type="text" id="contact_person" class="form-control" wire:model.defer="contact_person">
                            @error('contact_person')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="mb-3 col-md-4">
                            <label for="contact_person_phone"
                                class="form-label required">{{ __('Contact Person Telephone') }}</label>
                            <input type="text" id="contact_person_phone" class="form-control"
                                wire:model.defer="contact_person_phone">
                            @error('contact_person_phone')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="mb-3 col-md-4">
                            <label for="contact_person_email" class="form-label required">{{ __('Contact Person Email') }}</label>
                            <input type="email" id="contact_person_email" class="form-control"
                                wire:model.defer="contact_person_email">
                            @error('contact_person_email')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="mb-3 col-md-4">
                            <label for="website" class="form-label">{{ __('Website') }}</label>
                            <input type="url" id="website" class="form-control" wire:model.defer="website">
                            @error('website')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="mb-3 col-md-4">
                            <label for="country" class="form-label required">{{ __('Country') }}</label>
                            <select class="form-select" id="country" wire:model.lazy="country">
                                <option selected value="">Select</option>
                                @include('layouts.countries')
                            </select>
                            @error('country')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <hr>
                        <div class="mb-3 col-md-2">
                            <label for="payment_terms" class="form-label required">{{ __('Payment Terms') }}</label>
                            <select class="form-select" id="payment_terms" wire:model.lazy="payment_terms">
                                <option selected value="">Select</option>
                                <option value="net_15">Net 15</option>
                                <option value="net_30">Net 30</option>
                                <option value="net_45">Net 45</option>
                                <option value="net_60">Net 60</option>
                                <option value="net_90">Net 90</option>
                                <option value="due_on_receipt">Due on Receipt</option>
                                <option value="cash_on_delivery">Cash on Delivery (COD)</option>
                                <option value="payment_in_advance">Payment in Advance</option>
                                <option value="custom_terms">Custom Terms</option>
                            </select>
                            @error('payment_terms')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="mb-3 col-md-3">
                            <label for="payment_method" class="form-label required">{{ __('Payment Method') }}</label>
                            <select class="form-select" id="payment_method" wire:model.lazy="payment_method">
                                <option selected value="">Select</option>
                                <option value="cheque">Cheque</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="electronic_payment">Electronic Payment (ACH, EFT)</option>
                                <option value="paypal">PayPal</option>
                                <option value="cash">Cash</option>
                                <option value="cryptocurrency">Cryptocurrency</option>
                                <option value="mobile_payment">Mobile Payment</option>
                            </select>
                            @error('payment_method')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="mb-3 col-md-2">
                            <label for="preferred_currency" class="form-label required">{{ __('Preferred Currency') }}</label>
                            <select class="form-select" id="preferred_currency" wire:model.lazy="preferred_currency">
                                <option selected value="">Select</option>
                                @include('layouts.currencies')
                            </select>
                            @error('preferred_currency')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="mb-3 col-md-5">
                            <label for="bank_name" class="form-label required">{{ __('Bank Name') }}</label>
                            <input type="text" id="bank_name" class="form-control" wire:model.defer="bank_name">
                            @error('bank_name')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="mb-3 col-md-4">
                            <label for="branch" class="form-label required">{{ __('Bank Branch') }}</label>
                            <input type="text" id="branch" class="form-control" wire:model.defer="branch">
                            @error('branch')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="mb-3 col-md-4">
                            <label for="account_name" class="form-label required">{{ __('Account Name') }}</label>
                            <input type="text" id="account_name" class="form-control" wire:model.defer="account_name">
                            @error('account_name')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="mb-3 col-md-4">
                            <label for="bank_account" class="form-label required">{{ __('Account Number') }}</label>
                            <input type="text" id="bank_account" class="form-control" wire:model.defer="bank_account">
                            @error('bank_account')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <hr>
                        <div class="mb-3 col-md-2">
                            <label for="tin" class="form-label required">{{ __('TIN') }}</label>
                            <input type="text" id="tin" class="form-control" wire:model.defer="tin">
                            @error('tin')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="mb-3 col-md-2">
                            <label for="tax_withholding_rate" class="form-label">{{ __('Tax With-holding Rate') }}</label>
                            <input type="number" id="tax_withholding_rate" class="form-control"
                                wire:model.defer="tax_withholding_rate">
                            @error('tax_withholding_rate')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="mb-3 col-md-2">
                            <label for="is_active" class="form-label required">{{ __('Status') }}</label>
                            <select class="form-select" id="is_active" wire:model.lazy="is_active">
                                <option selected value="">Select</option>
                                <option value="1">Active</option>
                                <option value="0">Suspended</option>
                            </select>
                            @error('is_active')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="mb-3 col-md-6">
                            <label for="notes" class="form-label">{{ __('Notes') }}</label>
                            <textarea id="notes" class="form-control" wire:model.defer="notes"></textarea>
                            @error('notes')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
            
            
                    </div>
            
                    <div class="modal-footer">
                        <x-button type="submit" class="btn btn-success">{{ __('public.save') }}</x-button>
                    </div>
                </form>
                
            </div>

            <div class="tab-pane p-3" id="sector" role="tabpanel">
                <livewire:procurement.settings.inc.provider-sectors-component />
            </div>

            <div class="tab-pane p-3" id="documents" role="tabpanel">
                <livewire:procurement.settings.inc.provider-documents-component />
            </div>

        </div>
    </div>
</div>

