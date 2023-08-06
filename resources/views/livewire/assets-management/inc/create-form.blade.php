<div x-cloak x-show="create_new">
    <form wire:submit.prevent>
        <div class="row">
            <div class="mb-3 col-md-3">
                <label for="asset_categories_id" class="form-label required">{{ __('Category') }} </label>
                <select class="form-select select2" id="asset_categories_id" wire:model.lazy="asset_categories_id">
                    <option selected value="">Select</option>
                    @foreach ($categories as $category)
                        <option value='{{ $category->id }}'>{{ $category->name }} ({{$category->classification->name}})</option>
                    @endforeach
                </select>
                @error('asset_categories_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="asset_name" class="form-label required">{{ __('Asset Name') }} </label>
                <input type="text" id="asset_name" class="form-control" wire:model.defer="asset_name">
                @error('asset_name')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="brand" class="form-label">{{ __('Brand') }} </label>
                <input type="text" id="brand" class="form-control" wire:model.defer="brand">
                @error('brand')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="model" class="form-label">{{ __('Model') }} </label>
                <input type="text" id="model" class="form-control" wire:model.defer="model">
                @error('model')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="serial_number" class="form-label">{{ __('Serial Number') }} </label>
                <input type="text" id="serial_number" class="form-control" wire:model.defer="serial_number">
                @error('serial_number')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="barcode" class="form-label">{{ __('Barcode') }} </label>
                <input type="text" id="barcode" class="form-control" wire:model.defer="barcode">
                @error('barcode')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="engraved_label" class="form-label">{{ __('Engraved Label') }} </label>
                <input type="text" id="engraved_label" class="form-control" wire:model.defer="engraved_label">
                @error('engraved_label')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label for="description" class="form-label">{{ __('Description') }} </label>
                <textarea type="text" id="description" class="form-control" wire:model.defer="description"></textarea>
                @error('description')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <hr>
             
            <div class="mb-3 col-md-3">
                <label for="acquisition_type" class="form-label required">{{ __('Acquisition Type') }} </label>
                <select class="form-select" id="acquisition_type" wire:model.lazy="acquisition_type">
                    <option selected value="">Select</option>
                    <option value="Purchase">Purchase</option>
                    <option value="Lease">Lease</option>
                    <option value="Rent">Rent</option>
                    <option value="Donation">Donation/Gift</option>
                    <option value="Project">Project</option>
                    <option value="Build-to-suit">Build-to-Suit</option>
                    <option value="Trade-in">Trade-In</option>
                    <option value="Self-manufacturing">Self-Manufacturing</option>
                </select>
                @error('acquisition_type')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            @if ($acquisition_type == 'Project')
                <div class="mb-3 col-md-4">
                    <label for="project_id" class="form-label required">{{ __('Project') }} </label>
                    <select class="form-select select2" id="project_id" wire:model.lazy="project_id">
                        <option selected value="">Select</option>
                        @foreach ($departments as $department)
                            <option value='{{ $department->id }}'>{{ $department->name }}</option>
                        @endforeach
                    </select>
                    @error('project_id')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            <div class="mb-3 col-md-2">
                <label for="procurement_date" class="form-label">{{ __('Procurement Date') }} </label>
                <input type="date" id="procurement_date" class="form-control" wire:model.defer="procurement_date">
                @error('procurement_date')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="procurement_type" class="form-label">{{ __('Procurement Type') }} </label>
                <select class="form-select" id="procurement_type" wire:model.lazy="procurement_type">
                    <option selected value="">Select</option>
                    <option value="Request for Quotation">Request for Quotation (RFQ)</option>
                    <option value="Open Tender">Open Tender</option>
                    <option value="Restricted Tender">Restricted Tender</option>
                    <option value="Request for Proposal">Request for Proposal (RFP)</option>
                    <option value="Single-Source Procurement">Single-Source Procurement</option>
                    <option value="Emergency Procurement">Emergency Procurement</option>
                    <option value="Framework Agreement">Framework Agreement</option>
                    <option value="Direct Negotiation">Direct Negotiation</option>
                    <option value="Two-Step Tendering">Two-Step Tendering</option>
                    <option value="Reverse Auction">Reverse Auction</option>
                    <option value="Design-Build">Design-Build (DB)</option>
                    <option value="Design-Build-Operate">Design-Build-Operate (DBO)</option>
                    <option value="Public-Private Partnership">Public-Private Partnership (PPP)</option>
                </select>
                @error('procurement_type')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="invoice_number" class="form-label">{{ __('#Invoice No') }} </label>
                <input type="text" id="invoice_number" class="form-control" wire:model.defer="invoice_number">
                @error('invoice_number')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="cost" class="form-label">{{ __('Purchase Price') }} </label>
                <input type="number" id="cost" class="form-control" wire:model.defer="cost" step="0.01">
                @error('cost')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="currency" class="form-label">Currency</label>
                <select class="form-select" id="currency" wire:model.lazy='currency'>
                    <option selected value="">Select</option>
                    @include('layouts.currencies')
                </select>
                @error('currency')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="supplier_id" class="form-label">{{ __('Supplier') }} </label>
                <select class="form-select select2" id="supplier_id" wire:model.lazy="supplier_id">
                    <option selected value="">Select</option>
                    @foreach ($departments as $department)
                        <option value='{{ $department->id }}'>{{ $department->name }}</option>
                    @endforeach
                </select>
                @error('supplier_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <hr>

            <div class="mb-3 col-md-2">
                <label for="has_service_contract"
                    class="form-label required">{{ __('Has service contract?') }}</label>
                <select class="form-select select2" id="has_service_contract" wire:model.lazy="has_service_contract">
                    <option selected value="">Select</option>
                    <option value='1'>Yes</option>
                    <option value='0'>No</option>
                </select>
                @error('has_service_contract')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            @if ($has_service_contract)
                <div class="mb-3 col-md-2">
                    <label for="service_contract_expiry_date"
                        class="form-label">{{ __('Service Contract Expiry Date') }}
                    </label>
                    <input type="date" id="service_contract_expiry_date" class="form-control"
                        wire:model.defer="service_contract_expiry_date">
                    @error('service_contract_expiry_date')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-4">
                    <label for="service_provider" class="form-label">{{ __('Service Provider') }} </label>
                    <select class="form-select select2" id="service_provider" wire:model.lazy="service_provider">
                        <option selected value="">Select</option>
                        @foreach ($departments as $department)
                            <option value='{{ $department->id }}'>{{ $department->name }}</option>
                        @endforeach
                    </select>
                    @error('service_provider')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            <div class="mb-3 col-md-4">
                <label for="warranty_details" class="form-label">{{ __('Warranty Details') }} </label>
                <textarea type="text" id="warranty_details" class="form-control" wire:model.defer="warranty_details"></textarea>
                @error('warranty_details')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="useful_years" class="form-label">{{ __('Expected Useful Years') }} </label>
                <input type="number" id="useful_years" class="form-control" wire:model.defer="useful_years"
                    step="1">
                @error('useful_years')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="depreciation_method" class="form-label required">{{ __('Depreciation Method') }}</label>
                <select class="form-select select2" id="depreciation_method" wire:model.lazy="depreciation_method">
                    <option selected value="">Select</option>
                    <option value='Straight-Line Method'>Straight Line Method</option>
                    <option value='Reducing Balance Method'>Reducing Balance Method</option>
                </select>
                @error('depreciation_method')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            @if ($depreciation_method == 'Straight-Line Method')
                <div class="mb-3 col-md-2">
                    <label for="salvage_value" class="form-label">{{ __('Salvage/Residual Value') }} </label>
                    <input type="number" id="salvage_value" class="form-control" wire:model.defer="salvage_value"
                        step="0.01">
                    @error('salvage_value')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            <div class="mb-3 col-md-2">
                <label for="asset_condition" class="form-label required">{{ __('Asset Condition') }}</label>
                <select class="form-select select2" id="asset_condition" wire:model.lazy="asset_condition">
                    <option selected value="">Select</option>
                    <option value='Brand New'>Brand New</option>
                    <option value='Refurbished'>Refurbished</option>
                </select>
                @error('asset_condition')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="operational_status" class="form-label required">{{ __('Operational Status') }}</label>
                <select class="form-select" id="operational_status" wire:model.lazy="operational_status">
                    <option selected value="">Select</option>
                    <option value='1'>Operational</option>
                    <option value='0'>Non Operational</option>
                    <option value='2'>Retired</option>
                </select>
                @error('operational_status')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="modal-footer">
            @if (!$toggleForm)
                <x-button class="btn-success" wire:click='storeAsset'>{{ __('public.save') }}</x-button>
            @else
                <x-button class="btn-success" wire:click='updateAsset'>{{ __('public.update') }}</x-button>
            @endif
        </div>
    </form>
    <hr>
</div>
