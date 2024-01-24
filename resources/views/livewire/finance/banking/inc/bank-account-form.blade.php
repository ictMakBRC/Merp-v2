<div wire:ignore.self class="modal fade" id="updateCreateModal" tabindex="-1" role="dialog" aria-labelledby="updateCreateModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="updateCreateModalTitle">
                    @if (!$toggleForm)
                        New Account
                    @else
                        Edit Account
                    @endif
                </h6>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()" aria-label="Close"></button>
            </div><!--end modal-header-->     
            
            <form  @if ($toggleForm) wire:submit.prevent="updateAccount" @else wire:submit.prevent="storeAccount" @endif >             
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <label for="name" class="form-label required">Name</label>
                            <input type="text" id="name" class="form-control" name="name" required
                                wire:model="name">
                            @error('name')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-2">
                            <label for="name" class="form-label required">Branch</label>
                            <input type="text" id="name" class="form-control" name="branch" required
                                wire:model="branch">
                            @error('branch')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-3">
                            <label for="account_number" class="form-label required">Acct No.</label>
                            <input type="text" id="account_number" class="form-control" name="account_number" required
                                wire:model="account_no">
                            @error('account_number')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3 col-2">
                            <label for="account_type" class="form-label required">Account Type</label>
                            <select class="form-select select2" id="type" wire:model="account_type">
                                <option  value="">Select</option>
                                <option  value="Bank">Bank</option>
                                <option  value="Cash">Cash</option>
                            </select>
                            @error('account_type')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-2">
                            <label for="currency_id" class="form-label required">Account Currency</label>
                            <select class="form-select select2" id="currency_id" wire:model.defer="currency_id">
                                <option  value="">Select</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->name.' '.$currency->code }}</option>
                                @endforeach
                            </select>
                            @error('currency_id')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-3">
                            <label for="opening_balance" class="form-label required">Primary Balance</label>
                            <input type="text" id="opening_balance" oninput="formatAmount(this)" class="form-control"  name="opening_balance" required
                                wire:model.defer="opening_balance">
                            @error('opening_balance')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="as_of" class="form-label required">As of</label>
                            <input type="date" id="as_of" class="form-control" name="as_of" required
                                wire:model.defer="as_of">
                            @error('as_of')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-2">
                            <label for="is_active" class="form-label required">{{ __('public.status') }}</label>
                            <select class="form-select select2" id="is_active" wire:model.defer="is_active">
                                <option selected value="">Select</option>
                                <option value='1'>Active</option>
                                <option value='0'>Inactive</option>
                            </select>
                            @error('is_active')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col">
                            <label for="countryName" class="form-label">Description</label>
                            <textarea  id="description" class="form-control"
                            name="description" wire:model.defer="description"></textarea>
                            @error('description')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" wire:click="close()" >{{ __('public.close') }}</button>
                    @if($toggleForm) 
                    <x-button type="submit"  class="btn-success btn-sm">{{ __('public.update') }}</x-button>
                     @else 
                     <x-button type="submit"  class="btn-success btn-sm">{{ __('public.save') }}</x-button>
                     @endif
                </div><!--end modal-footer-->
            </form>
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
</div><!--end modal-->