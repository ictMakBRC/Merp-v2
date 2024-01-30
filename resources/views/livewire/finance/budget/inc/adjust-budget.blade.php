<div wire:ignore.self class="modal fade" id="adjustBudgetModal" tabindex="-1" role="dialog" aria-labelledby="viewBudgetModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="viewBudgetModal">
                 Adjust Budget
                </h6>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!--end modal-header-->     
            <form   wire:submit.prevent="makeTransfer()">             
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="status" class="form-label required">From Line</label>
                            <select id="status" class="form-control form-select" required
                                wire:model="from_line">
                                <option value="">Select</option>
                                @foreach ($budget_lines->where('type','Expense') as $formLine)
                                  <option value="{{ $formLine->id }}">{{ $formLine->name.' Amt '. $formLine->primary_balance }}</option>
                                @endforeach
                            </select>
                            @error('from_line')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>   
                        <div class="mb-3 col-6">
                            <label for="status" class="form-label required">To Line</label>
                            <select id="to_line" class="form-control form-select" required
                                wire:model="to_line">
                                <option value="">Select</option>
                                @foreach ($budget_lines->where('type','Expense') as $toLine)
                                  <option value="{{ $toLine->id }}">{{ $toLine->name.' Amt '. $toLine->primary_balance }}</option>
                                @endforeach
                            </select>
                            @error('to_line')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>  
                        <div class="mb-3 col-12">
                            <label for="transfer_amount" class="form-label required">Amount <small>Maximun Transfer: @moneyFormat( $max_amount )</small></label>
                            <input type="number" max="{{ $max_amount }}" step="any" id="transfer_amount" class="form-control form-select" required
                                wire:model="transfer_amount">
                            @error('transfer_amount')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div> 
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" wire:click="close()" >{{ __('public.close') }}</button>
                    <x-button type="submit"  class="btn-success btn-sm">{{ __('public.save') }}</x-button>         
                </div><!--end modal-footer-->
            </form>
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
</div><!--end modal-->