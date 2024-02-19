<div wire:ignore.self class="modal fade" id="approveBudgetModal" tabindex="-1" role="dialog" aria-labelledby="viewBudgetModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="viewBudgetModal">
                 Approve Budget
                </h6>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!--end modal-header-->     
            <form   wire:submit.prevent="approveBudget()">             
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-3">
                            <label for="status" class="form-label required">Action</label>
                            <select id="status" class="form-control form-select" required
                                wire:model="status">
                                <option value="">Select</option>
                                <option value="Pending">Mark as Pending</option>
                                <option value="Approved">Approved</option>
                            </select>
                            @error('status')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col">
                            <label for="payment_ref" class="form-label required">Comment</label>
                            <input type="text" id="comment" class="form-control" required
                                wire:model.defer="comment">
                            @error('comment')
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