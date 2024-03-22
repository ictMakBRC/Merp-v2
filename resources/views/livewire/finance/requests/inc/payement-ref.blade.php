<div wire:ignore.self class="modal fade" id="markPaid" tabindex="-1" role="dialog" aria-labelledby="updateCreateModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="markPaid">
                  Complete Request
                </h6>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()" aria-label="Close"></button>
            </div><!--end modal-header-->     
            
            <form   wire:submit.prevent="payRequest({{ $request_data->id }})">             
                <div class="modal-body">
                    <div class="row">
                        <div class="12">
                          Amount to be paid  @moneyFormat($request_data->total_amount ?? '0') ({{ $request_data->currency->code ?? 'N/A' }})
                        </div>
                        <div class="mb-3 col">
                            <label for="payment_ref" class="form-label required">Amount Paid</label>
                            <input type="text" id="payment_ref" class="form-control" required
                                wire:model.defer="amount_paid">
                            @error('payment_ref')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>       
                        @if ($request_data->request_type != 'Internal Transfer')                 
                            <div class="mb-3 col-6">
                                <label for="bank_id" class="form-label required">Bank</label>
                                <select id="bank_id" class="form-control form-select" name="bank_id" required
                                    wire:model="bank_id">
                                    <option value="">Select</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->name.' Acct '.$bank->account_no.' '.$bank?->currency?->code }}</option>
                                    @endforeach
                                </select>
                                @error('bank_id')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
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