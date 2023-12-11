<div x-cloak x-show="create_new">
    <form
        @if ($toggleForm) wire:submit.prevent="updateInvoice" @else wire:submit.prevent="storeInvoice" @endif>

        <div class="row">
            @include('livewire.partials.single-project-department-toggle')
            
            <div class="mb-3 col col-12 col col-sm-4">
                <label for="invoice_to" class="form-label required">Billed To</label>
                <select class="form-control form-select" id="invoice_to" wire:model='invoice_to'>
                    <option selected value="">Select</option>
                    <option value="Customer">Customer</option>
                    <option value="Department">Department</option>
                    <option value="Project">Project</option>
                </select>
                @error('invoice_to')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            @if ($invoice_to == 'Customer')

                <div class="mb-3 col-md-3">
                    <label for="name" class="form-label required">Customer Name</label>
                    <select id="customer_id" wire:model='customer_id' required class="form-control form-select">
                        <option value="">Select</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-md-3">
                    <label for="name" class="form-label ">Project</label>
                    <select id="billed_project" wire:model='billed_project' class="form-control form-select">
                        <option value="">Select</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                    @error('billed_project')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>
            @elseif ($invoice_to == 'Project')
            <div class="mb-3 col col-12 col-md-4  col-sm-3">
                    <label for="project_id" class="form-label required">Billed Project</label>
                    <select class="select2 form-select" id="billed_project" wire:model='billed_project'>
                        <option selected value="">Select</option>
                        @foreach ($projects as $project)
                            <option value='{{ $project->id }}'>{{ $project->name }}</option>
                        @endforeach
                    </select>
                    @error('billed_project')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
            </div>
            @elseif($invoice_to =='Department')
            <div class="mb-3 col col-12 col-md-4  col-sm-3">
                    <label for="department_id" class="form-label required">Billed Department</label>
                    <select class="select2 form-select" id="billed_department" wire:model='billed_department'>
                        <option selected value="">Select</option>
                        @foreach ($departments as $department)
                            <option value='{{ $department->id }}'>{{ $department->name }}</option>
                        @endforeach
                    </select>
                    @error('billed_department')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>
            @endif 

            <div class="mb-3 col-2">
                <label for="currency_id" class="form-label required">Currency</label>
                <select id="currency_id" class="form-control form-select" name="currency_id" required
                    wire:model="currency_id">
                    <option value="">Select</option>
                    @foreach ($currencies as $currency)
                        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                    @endforeach
                </select>
                @error('currency_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-2">
                <label for="opening_balance" class="form-label required">As of</label>
                <input type="date" id="invoice_date" max="{{date('Y-m-d')}}" class="form-control" wire:model='invoice_date'>
                @error('invoice_date')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-2">
                <label for="due_date" class="form-label required">Due Date</label>
                <input type="date" id="due_date" min="{{$invoice_date ?? date('Y-m-d')}}" class="form-control" wire:model.defer='due_date'>
                @error('due_date')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-2">
                <div class="form-group select-placeholder">
                    <label for="recurring" class="form-label required">
                        Recurring Invoice? </label>
                    <select class="form-select" data-width="100%" name="recurring" wire:model='recurring'>
                        <option value="">Select</option>
                        <option value="0">No</option>
                        <option value="1">Every 1 month</option>
                        <option value="2">Every 2 months</option>
                        <option value="3">Every 3 months</option>
                        <option value="4">Every 4 months</option>
                        <option value="5">Every 5 months</option>
                        <option value="6">Every 6 months</option>
                        <option value="7">Every 7 months</option>
                        <option value="8">Every 8 months</option>
                        <option value="9">Every 9 months</option>
                        <option value="10">Every 10 months</option>
                        <option value="11">Every 11 months</option>
                        <option value="12">Every 12 months</option>
                    </select>
                </div>
                @error('recurring')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            @if ($recurring != 0)
                <div class="mb-3 col-2">
                    <label for="due_date" class="form-label required">Number of Times</label>
                    <input type="number" id="cycles" min="1" class="form-control" wire:model='cycles'>
                    @error('cycles')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            <div class="col-md-2">
                <div class="form-group select-placeholder">
                    <label for="recurring" class="form-label required">
                        Don't sending overdue reminders</label>
                    <select class="form-select" data-width="100%" name="cancel_overdue_reminders"
                         wire:model='cancel_overdue_reminders'>
                        <option value="0">No</option>
                        <option value="1">Yes</option>                        
                    </select>
                </div>
                @error('cancel_overdue_reminders')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
            </div>

            <div class="mb-3 col">
                <label for="address" class="form-label">Description</label>
                <textarea id="description" class="form-control text-uppercase"
                    wire:model.defer='description'></textarea>
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
