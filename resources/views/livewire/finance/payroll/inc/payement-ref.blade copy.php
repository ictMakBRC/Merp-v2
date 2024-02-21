<div wire:ignore.self class="modal fade" id="markPaid" tabindex="-1" role="dialog" aria-labelledby="updateCreateModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="markPaid">
                    @if($pay=='Single')
                    Mark {{ $payroll_employee_data?->employee?->fullName??'' }} {{ $pay }} payment @moneyFormat($payroll_employee_data?->salary??null) As paid
                    @elseif($pay=='PayrollRate')
                    Mark All {{ $rateData->currency->code }} salaries as Paid
                    @endif
                </h6>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()" aria-label="Close"></button>
            </div><!--end modal-header-->     
            
            <form   wire:submit.prevent="savePaymentRecord()" >             
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-8">
                            <label for="payment_ref" class="form-label required">Payment Reference</label>
                            <input type="text" id="payment_ref" class="form-control" required
                                wire:model.defer="payment_ref">
                            @error('payment_ref')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3 col-4">
                            <label for="payment_ref" class="form-label required">Payment Date</label>
                            <input type="date" id="payment_date" class="form-control" required
                                wire:model.defer="payment_date">
                            @error('payment_date')
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