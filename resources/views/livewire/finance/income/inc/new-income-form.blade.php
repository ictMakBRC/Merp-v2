<div x-cloak x-show="create_new">
    <form wire:submit.prevent="storeTransaction" >             

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
                <div class="mb-3 col">
                    <label for="total_amount" class="form-label required">Amount</label>
                    <div class="input-group">
                    <input type="text" id="total_amount"  class="form-control" name="total_amount" required
                        wire:model="total_amount">
                        <span class="input-group-text">Base</span>
                        <input id="baseAmount" readonly class="form-control" name="baseAmount" required wire:model="baseAmount" step="any"  type="number">
                    </div>
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
            @if ($viewSummary )            
            <div class="row">
                    <div class="col-12">                    
                        <table class="table table-sm">
                            <tr>
                                <td>Budget Line Balance</td> 
                                <td>@moneyFormat($budgetLineBalance) + @moneyFormat($budgetExpense) = @moneyFormat($budgetNewBal)</td>
                            </tr>
                            <tr>
                                <td>Ledger Balance</td> 
                                <td>@moneyFormat($ledgerBalance) + @moneyFormat($ledgerExpense) = @moneyFormat($ledgerNewBal)</td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <x-button class="btn btn-success">{{ __('public.save') }}</x-button>
                    </div>
            </div>
            @else
            </form>
            <div class="modal-footer">
                <a class="btn btn-outline-success" wire:click='generateTransaction'>Generate Income</a>
            </div>
            @endif
        </form>
    <hr>
</div>
