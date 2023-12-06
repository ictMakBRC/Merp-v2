<div wire:ignore.self class="modal fade" id="updateCreateModal" tabindex="-1" role="dialog" aria-labelledby="updateCreateModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="updateCreateModalTitle">
                    New currency Rate
                </h6>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()" aria-label="Close"></button>
            </div><!--end modal-header-->     
            
            <form   wire:submit.prevent="storeRate()" >             
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="currency_id" class="form-label required">Currency</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    1
                                </div>
                                <select name="currency_id" id="currency_id" class="form-control" name="currency_id" required
                                    wire:model.defer="currency_id">
                                    <option value="">Select</option>
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}">{{ $currency->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('currency_id')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3 col-md-6">
                            <label for="exchange_rate" class="form-label required">Exchange Rate</label>
                            <div class="input-group">
                            <input type="text" id="exchange_rate" class="form-control" name="exchange_rate" required
                                wire:model.defer="exchange_rate">
                                <div class="input-group-text">
                                    {{ $baseCurrency->code??'UGX' }}
                                </div>
                            </div>
                            @error('exchange_rate')
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