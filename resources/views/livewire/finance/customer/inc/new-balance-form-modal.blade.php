<div wire:ignore.self class="modal fade" id="addOpeningBalance" tabindex="-1" role="dialog" aria-labelledby="updateCreateModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="addOpeningBalance">
                   Add Direct Balance to {{ $billtable->name??'' }} Customer
                </h6>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()" aria-label="Close"></button>
            </div><!--end modal-header-->     
            
            <form  wire:submit.prevent="addBalance" >             
                <div class="modal-body">
                    <div class="row">
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
                            <label for="currency_id" class="form-label required">Account Currency</label>
                            <select class="form-select select2" id="currency_id" wire:model="currency_id">
                                <option  value="">Select</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->name.' '.$currency->code }}</option>
                                @endforeach
                            </select>
                            @error('currency_id')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-5">
                            <label for="opening_balance" class="form-label required">Primary Balance</label>
                            <div class="input-group">
                            <input type="text" id="opening_balance" oninput="formatAmount(this)" class="form-control"  name="opening_balance" required
                                wire:model.defer="opening_balance">
                                <span class="input-group-text">Rate</span>
                                <input type="text" id="rate" oninput="formatAmount(this)" class="form-control"  name="rate" required
                                wire:model.defer="rate">
                            </div>
                            @error('opening_balance')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="invoice_date" class="form-label required">As of</label>
                            <input type="date" id="as_of" class="form-control" min="{{ $min_date }}" max ="{{ $max_date }}" name="invoice_date" required
                                wire:model.defer="invoice_date">
                            @error('invoice_date')
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