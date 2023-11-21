<div x-cloak x-show="create_new">
    <form wire:submit.prevent="storePaymentRequest" >             
        @include('layouts.messages')
            <div class="row">     
                @include('livewire.partials.project-department-toggle')           
             
                <div class="mb-3 col-2">
                    <label for="ledger_account" class="form-label required">Ledger</label>
                    <select id="ledger_account" class="form-control" name="ledger_account" required wire:model="ledger_account">
                        <option value="">Select</option>
                        @foreach ($ledgers as $ledger)
                            <option value="{{$ledger->id}}">{{$ledger->name}}</option>
                        @endforeach
                    </select>
                    @error('ledger_account')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                    @if ($ledgerBalance)
                        <small class="text-primary"><strong>Balance:</strong>{{ $ledgerBalance.' '.$ledgerCur }}</small>
                        <small class="text-info"><strong>Balance:</strong>{{exchangeCurrency($ledgerCur, 'base',  $ledgerBalance).' UGX' }}</small>
                    @endif
                </div>   
                <div class="mb-3 col-2">
                    <label for="budget_line_id" class="form-label required">Budget Line to charge</label>
                    <select id="budget_line_id" class="form-control" name="budget_line_id" required wire:model="budget_line_id">
                        <option value="">Select</option>
                        @foreach ($budgetLines as $budgetLine)
                            <option value="{{$budgetLine->id}}">{{$budgetLine->name}}</option>
                        @endforeach
                    </select>
                    @error('budget_line_id')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                    @if ($budgetLineBalance)
                        <small class="text-primary"><strong>Balance:</strong>{{ $budgetLineBalance.' '.$budgetLineCur }}</small>
                        <small class="text-info"><strong>Balance:</strong>{{exchangeCurrency($budgetLineCur, 'base', $budgetLineBalance).' UGX' }}</small>
                    @endif
                </div>   
                <div class="mb-3 col-4">
                    <label for="currency_id" class="form-label required">Currency</label>
                    <div class="input-group">
                        <select id="currency_id" class="form-control" name="currency_id" required wire:model="currency_id">
                            <option value="">Select</option>
                            @foreach ($currencies as $currency)
                                <option value="{{$currency->id}}">{{$currency->code}}</option>
                            @endforeach
                        </select>
                        <span class="input-group-text">Rate</span>
                        <input id="rate" class="form-control" name="rate" required wire:model="rate"  type="number">
                    </div>
                
                    @error('currency_id')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div> 
                <div class="col-md-4">
                    <label class="form-label required" for="month">Month:</label>
                    <select class="form-select" wire:model="month" id="month">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">{{ \Carbon\Carbon::create(null, $i, 1)->format('F') }}</option>
                        @endfor
                    </select>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label required"  for="year">Year:</label>
                    <select class="form-select" wire:model="year" id="year">
                        @for ($i = date('Y'); $i >= (date('Y') - 10); $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>    
            </div>
            <div class="modal-footer">
                <x-button class="btn btn-success">Proceed</x-button>
            </div>
        </form>
    <hr>
</div>
