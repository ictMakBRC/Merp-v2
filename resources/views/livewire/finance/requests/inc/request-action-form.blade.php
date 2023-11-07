<div wire:ignore.self class="modal fade" id="approveRejectRequest-modal" tabindex="-1" role="dialog" aria-labelledby="updateCreateModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="approveRejectRequest">
                   Approve/Reject Request #{{ $request_data->request_description ?? 'N/A' }} amount of @moneyFormat($request_data->total_amount ?? '0')
                </h6>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()" aria-label="Close"></button>
            </div><!--end modal-header-->     
            
            <form  wire:submit.prevent="approveRejectRequest({{ $request_data->id }})" >             
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label required">Date {{ $click_action }}: <b>{{ date('d-m-Y') }}</b></label>                          
                        </div>
                        <div class="col-12">
                            <h5>Ledger Balance: <b>@moneyFormat($request_data->fromAccount->current_balance??0)</b> &nbsp; <br>
                                Amount in queue(this @moneyFormat($request_data->ledger_amount ?? '0') inclusive): <b> @moneyFormat($request_data->fromAccount->amount_held??0)</b></h5>
                        </div>
                        <hr>
                        <div class="col-12">
                            <h5>Budget-line Balance: <b>@moneyFormat($request_data->budgetLine->primary_balance??0)</b> &nbsp;<br>
                                 Amount in queue(this @moneyFormat($request_data->budget_amount ?? '0') inclusive): <b> @moneyFormat($request_data->budgetLine->amount_held??0)</b></h5>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="comment" class="form-label">Comment @if ($click_action=='Declined') <small class="text-danger">Please give a comment as to why you declined the request</small> @endif </label>
                            <textarea type="text" id="comment" class="form-control" name="comment" 
                                @if ($click_action=='Declined')required @endif 
                                wire:model.defer="comment"></textarea>
                            @error('comment')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                       
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" wire:click="close()" >{{ __('public.close') }}</button>
                    <x-button type="submit"  class="btn-success btn-sm">{{ __('Done') }}</x-button>
                </div><!--end modal-footer-->
            </form>
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
</div><!--end modal-->