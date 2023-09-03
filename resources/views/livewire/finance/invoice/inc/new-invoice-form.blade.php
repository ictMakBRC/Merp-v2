<div x-cloak x-show="create_new">
    <form  @if ($toggleForm) wire:submit.prevent="updateInvoice" @else wire:submit.prevent="storeInvoice" @endif >             

        <div class="row">    
            <div class="mb-3 col-2">
                <label for="invoice_type" class="form-label required">Invoice Type</label>
                <select id="invoice_type" class="form-control form-select" name="invoice_type" required wire:model="invoice_type">
                    <option value="">Select</option>
                    <option value="External">External</option>
                    <option value="Internal">Internal</option>
                </select>
                @error('invoice_type')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>    
            <div class="mb-3 col-md-3">
                <label for="name" class="form-label required">Invoice From</label>
                <select  id="invoice_from" wire:model='invoice_from' class="form-control form-select">
                    <option value="">Select</option>
                    @foreach ($departments as $department)
                        <option value="{{$department->id}}">{{$department->name}}</option>
                    @endforeach
                </select>
                @error('invoice_from')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div> 

            @if ($invoice_type =='External')
                    
            <div class="mb-3 col-md-3">
                <label for="name" class="form-label required">Customer Name</label>
                <select  id="customer_id" wire:model='customer_id' class="form-control form-select">
                    <option value="">Select</option>
                    @foreach ($customers as $customer)
                        <option value="{{$customer->id}}">{{$customer->name}}</option>
                    @endforeach
                </select>
                @error('customer_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-md-3">
                <label for="name" class="form-label required">Project</label>
                <select  id="project_id" wire:model='project_id' class="form-control form-select">
                    <option value="">Select</option>
                    @foreach ($projects as $project)
                        <option value="{{$project->id}}">{{$project->name}}</option>
                    @endforeach
                </select>
                @error('project_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            @else

            <div class="mb-3 col-md-3">
                <label for="name" class="form-label required">Invoice To</label>
                <select  id="department_id" wire:model='department_id' class="form-control form-select">
                    <option value="">Select</option>
                    @foreach ($departments as $department)
                        <option value="{{$department->id}}">{{$department->name}}</option>
                    @endforeach
                </select>
                @error('department_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div> 
                
            @endif


            <div class="mb-3 col-2">
                <label for="currency_id" class="form-label required">Currency</label>
                <select id="currency_id" class="form-control form-select" name="currency_id" required wire:model="currency_id">
                    <option value="">Select</option>
                    @foreach ($currencies as $currency)
                        <option value="{{$currency->id}}">{{$currency->name}}</option>
                    @endforeach
                </select>
                @error('currency_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>       
            
                        
            <div class="mb-3 col-2">
                <label for="opening_balance" class="form-label required">As of</label>
                <input type="date" id="invoice_date" class="form-control" wire:model.defer='invoice_date'>
                @error('invoice_date')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            
            <div class="mb-3 col">
                <label for="address" class="form-label">Description</label>
                <input type="text" id="description" class="form-control text-uppercase" wire:model.defer='description'>
                @error('description')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>   
            
        </div>
        <div class="modal-footer">
            <x-button class="btn btn-success">{{ __('create') }}</x-button>
        </div>
        <hr>
    </form>
    <hr>
</div>
