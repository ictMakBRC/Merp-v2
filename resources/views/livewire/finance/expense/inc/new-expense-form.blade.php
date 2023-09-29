<div x-cloak x-show="create_new">
    <form  @if ($toggleForm) wire:submit.prevent="updateBudget" @else wire:submit.prevent="storeBudget" @endif >             

        <div class="row">          

            @include('livewire.partials.project-department-toggle')           
            <div class="mb-3 col-2">
                <label for="fiscal_year" class="form-label required">Fiscal year</label>
                <select id="fiscal_year" class="form-control" name="fiscal_year" required wire:model="fiscal_year">
                    <option value="">Select</option>
                    @foreach ($years as $fy)
                        <option value="{{$fy->id}}">{{$fy->name}}</option>
                    @endforeach
                </select>
                @error('fiscal_year')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-2">
                <label for="from_account" class="form-label required">Ledger @if ($ledgerBalance)
                    <small><strong>Balance:</strong>{{ $ledgerBalance }}</small>
                @endif</label>
                <select id="from_account" class="form-control" name="from_account" required wire:model="from_account">
                    <option value="">Select</option>
                    @foreach ($ledgers as $ledger)
                        <option value="{{$ledger->id}}">{{$ledger->name}}</option>
                    @endforeach
                </select>
                @error('from_account')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>   
            <div class="mb-3 col-2">
                <label for="budget_line_id" class="form-label required">Budget Line</label>
                <select id="budget_line_id" class="form-control" name="budget_line_id" required wire:model="budget_line_id">
                    <option value="">Select</option>
                    @foreach ($budgetLines as $budgetLine)
                        <option value="{{$budgetLine->id}}">{{$budgetLine->name}}</option>
                    @endforeach
                </select>
                @error('budget_line_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>   
            <div class="mb-3 col-2">
                <label for="currency_id" class="form-label required">Currency</label>
                <select id="currency_id" class="form-control" name="currency_id" required wire:model="currency_id">
                    <option value="">Select</option>
                    @foreach ($currencies as $currency)
                        <option value="{{$currency->id}}">{{$currency->name}}</option>
                    @endforeach
                </select>
                @error('currency_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div> 
            <div class="mb-3 col">
                <label for="total_amount" class="form-label required">Amount</label>
                <input type="text" id="total_amount"  class="form-control" name="total_amount" required
                    wire:model="total_amount">
                @error('total_amount')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>            
            
            <div class="mb-3 col-md-4">
                <label for="description" class="form-label">Description</label>
                <textarea  id="description" class="form-control"
                name="description" wire:model.defer="description"></textarea>
                @error('description')
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
