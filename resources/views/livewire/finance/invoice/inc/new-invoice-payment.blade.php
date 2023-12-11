<div wire:ignore.self class="modal fade" id="NewPaymentModal" tabindex="-1" role="dialog"
    aria-labelledby="NewPaymentModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="NewPaymentModal">
                   New invoice payment
                </h6>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()"
                    aria-label="Close"></button>
            </div><!--end modal-header-->
            <form wire:submit.prevent="savePayment({{ $invoice_data->id }})">

                <div class="row p-4">

                    {{-- <div class="mb-3 col-6">
                        <label for="opening_balance" class="form-label required">Amount Received</label>
                        <input type="number" max="{{ $payment_balance }}" step="any" id="payment_amount" class="form-control" wire:model='payment_amount'>
                        @error('payment_amount')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div> --}}
                      
                    <div class="mb-3 col-2">
                        <label for="status" class="form-label required">Mode</label>
                        <select id="status" class="form-control form-select" name="status" required
                            wire:model="status">
                            <option value="">Select</option>
                            <option value="Bank">Bank</option>
                            <option value="Cash">Cash</option>
                        </select>
                        @error('status')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-4">
                        <label for="payment_balance" class="form-label required">Amount Remaining({{ $currency }})</label>
                        <input readonly type="number" step="any" id="payment_balance" class="form-control" wire:model='payment_balance'>
                        @error('payment_balance')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-6">
                        <label for="payment_amount" class="form-label required">Amount Received({{ $currency }})</label>
                        <div class="input-group">
                        <input type="text" id="payment_amount"  class="form-control" name="payment_amount" required
                            wire:model="payment_amount">
                            <span class="input-group-text">Base({{ $rate }})</span>
                            <input id="baseAmount" readonly class="form-control" name="baseAmount" required wire:model="baseAmount" step="any"  type="number">
                        </div>
                        @error('payment_amount')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mb-3 col-3">
                        <label for="opening_balance" class="form-label required">Payment Date</label>
                        <input type="date" id="as_of" class="form-control" wire:model.defer='as_of'>
                        @error('as_of')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-4">
                        <label for="to_account" class="form-label required">Ledger</label>
                        <select id="to_account" class="form-control" name="to_account" required wire:model="to_account">
                            <option value="">Select</option>
                            @foreach ($ledgers as $ledger)
                                <option value="{{$ledger->id}}">{{$ledger->name}}</option>
                            @endforeach
                        </select>
                        @error('to_account')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                        @if ($ledgerBalance)
                            <small class="text-primary"><strong>Balance:</strong>{{ $ledgerBalance.' '.$ledgerCur }}</small>
                            <small class="text-info"><strong>Balance:</strong>{{exchangeCurrency($ledgerCur, 'base',  $ledgerBalance).' UGX' }}</small>
                        @endif
                    </div> 

                    <div class="mb-3 col-5">
                        <label for="to_budget_line_id" class="form-label required">Income Budget Line</label>
                        <select id="to_budget_line_id" class="form-control" name="to_budget_line_id" required wire:model="to_budget_line_id">
                            <option value="">Select</option>
                            @foreach ($toBudgetLines as $line)
                                <option value="{{$line->id}}">{{$line->name}}</option>
                            @endforeach
                        </select>
                        @error('to_budget_line_id')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div> 
                    
                    <div class="mb-4 col-12">
                        <label for="address" class="form-label">Description</label>
                        <textarea  id="description" class="form-control text-uppercase"
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
    </div>
</div>
