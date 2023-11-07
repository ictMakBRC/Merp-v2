<div wire:ignore.self class="modal fade" id="internalTransferModal" tabindex="-1" role="dialog"
    aria-labelledby="internalTransferModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="interPaymentModal">
                    New invoice payment
                </h6>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()"
                    aria-label="Close"></button>
            </div><!--end modal-header-->
            <form wire:submit.prevent="storeRequest">
                @include('layouts.messages')
                <div class="modal-body">
                    <div class="row">


                        <div class="mb-3 col-4">
                            <label for="from_account" class="form-label required">From Account</label>
                            <select id="from_account" class="form-control" name="from_account" required
                                wire:model="from_account">
                                <option value="">Select</option>
                                <option value="{{ $ledger->id ?? '' }}">{{ $ledger->name ?? 'NA' }}</option>
                            </select>
                            @error('from_account')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                            @if ($ledgerBalance)
                                <small
                                    class="text-primary"><strong>Balance:</strong>{{ $ledgerBalance . ' ' . $ledgerCur }}</small>
                                <small
                                    class="text-info"><strong>Balance:</strong>{{ exchangeCurrency($ledgerCur, 'base', $ledgerBalance) . ' UGX' }}</small>
                            @endif
                        </div>
                        <div class="mb-3 col-4">
                            <label for="budget_line_id" class="form-label required">Budget Line to charge</label>
                            <select id="budget_line_id" class="form-control" name="budget_line_id" required
                                wire:model="budget_line_id">
                                <option value="">Select</option>
                                @foreach ($budgetLines as $budgetLine)
                                    <option value="{{ $budgetLine->id }}">{{ $budgetLine->name }}</option>
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
                            <label for="to_account" class="form-label required">To Account</label>
                            <select id="to_account" class="form-control" name="to_account" required wire:model="to_account">
                                <option value="">Select</option>
                                <option value="{{ $to_ledger->id ?? '' }}">{{ $to_ledger->name ?? 'N/A' }}</option>

                            </select>
                            @error('to_account')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-4">
                            <label for="currency_id" class="form-label required">Currency</label>
                            <div class="input-group">
                                <select id="currency_id" class="form-control" name="currency_id" required
                                    wire:model="currency_id">
                                    <option value="">Select</option>
                                    <option value="{{ $currency_id }}">{{ $currency }}</option>
                                </select>
                                <span class="input-group-text">Rate</span>
                                <input id="rate" class="form-control" name="rate" required wire:model="rate"
                                    type="number">
                            </div>

                            @error('currency_id')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-4">
                            <label for="total_amount" class="form-label required">Amount({{ $currency }})</label>
                            <div class="input-group">
                                <input type="text" id="total_amount" class="form-control" name="total_amount" required
                                    wire:model="amount">
                                <span class="input-group-text">Base</span>
                                <input id="baseAmount" readonly class="form-control" name="baseAmount" required
                                    wire:model="baseAmount" step="any" type="number">
                            </div>
                            @error('amount')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-4">
                            <label for="total_amount" class="form-label required">Amount in words</label>
                            <div class="input-group">
                                <input id="amount_in_words" class="form-control" name="amount_in_words" required
                                    wire:model.defer="amount_in_words" type="text">
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
                            <textarea id="notice_text" class="form-control" name="notice_text" wire:model.defer="notice_text"></textarea>
                            @error('notice_text')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    @if ($viewSummary)
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-sm">
                                    <tr>
                                        <td>Budget Line Balance ({{ $budgetLineCur }})</td>
                                        <td>@moneyFormat($budgetLineBalance) - @moneyFormat($budgetExpense) = @moneyFormat($budgetNewBal)</td>
                                    </tr>
                                    <tr>
                                        <td>Ledger Balance ({{ $ledgerCur }})</td>
                                        <td>@moneyFormat($ledgerBalance) - @moneyFormat($ledgerExpense) = @moneyFormat($ledgerNewBal)</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <x-button wire:click="storeRequest" class="btn btn-success">Proceed</x-button>
                            </div>
                        </div>
                    @else
                </div>
            {{-- </form> --}}
            <div class="modal-footer">
                <a class="btn btn-outline-success" wire:click='generateTransaction'>Generate Request</a>
            </div>
            @endif
            <hr>
        </div>
    </div>
</div>
