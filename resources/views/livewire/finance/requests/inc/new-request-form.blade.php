<div x-cloak x-show="create_new">
    <form wire:submit.prevent="storeTransaction" >             
        @include('layouts.messages')
            <div class="row">          
                <div class="col-2">
                    <label for="type" class="form-label required">Request Type @if ($request_type =='Petty Cash' || $request_type =='Cash Imprest') <small>Max = @moneyFormat($max)</small> @endif </label>
                    <select id="request_type" class="form-control" name="request_type" required wire:model="request_type">
                        <option value="">Select</option>
                        <option value="Payment">Payment Request</option>
                        <option value="Petty Cash">Petty Cash Request</option>
                        <option value="Cash Imprest">Cash Imprest Request</option>
                        {{-- <option value="Salary">Salary Request</option> --}}
                    </select>
                    @error('request_type')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div> 
                @if ($unit_type == 'all')
                    @include('livewire.partials.project-department-toggle')
                @else
                    @include('livewire.partials.single-project-department-toggle')
                @endif            
             
                <div class="mb-3 col-3">
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
                <div class="mb-3 col-3">
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
                <div class="mb-3 col-3">
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
                <div class="mb-3 col-4">
                    <label for="total_amount" class="form-label required">Amount({{$budgetLineCur}})</label>
                    <div class="input-group">
                    <input type="text" id="total_amount" max="{{ $max }}"  class="form-control" name="total_amount" required
                        wire:model="total_amount">
                        <span class="input-group-text">Base</span>
                        <input id="baseAmount" max="{{ $max }}" readonly class="form-control" name="baseAmount" required wire:model="baseAmount" step="any"  type="number">
                    </div>
                    @error('total_amount')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div> 

                <div class="mb-3 col-5">
                    <label for="total_amount" class="form-label required">Amount in words</label>
                    <div class="input-group">                    
                        <input id="amount_in_words" class="form-control" name="amount_in_words" required wire:model.defer="amount_in_words"  type="text">
                    </div>
                    @error('amount_in_words')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div> 
                
                <div class="mb-3 col-md-6">
                    <label for="description" class="form-label">Request Description</label>
                    <input type="text" id="request_description" class="form-control"
                    name="request_description" wire:model.defer="request_description">
                    @error('request_description')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3 col-md-5">
                    <label for="notice_text" class="form-label">Special Notices</label>
                    <textarea  id="notice_text" class="form-control"
                    name="notice_text" wire:model.defer="notice_text"></textarea>
                    @error('notice_text')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            @if ($viewSummary )            
            <div class="row">
                    <div class="col-12">                    
                        <table class="table table-sm">
                            <tr>
                                <td>Budget Line Balance</td> 
                                <td>@moneyFormat($budgetLineBalance) - @moneyFormat($budgetExpense) = @moneyFormat($budgetNewBal)</td>
                            </tr>
                            <tr>
                                <td>Ledger Balance</td> 
                                <td>@moneyFormat($ledgerBalance) - @moneyFormat($ledgerExpense) = @moneyFormat($ledgerNewBal)</td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <x-button class="btn btn-success">Proceed</x-button>
                    </div>
            </div>
            @else
            </form>
            <div class="modal-footer">
                <a class="btn btn-outline-success" wire:click='generateTransaction'>Generate Request</a>
            </div>
            @endif
        </form>
    <hr>
</div>
