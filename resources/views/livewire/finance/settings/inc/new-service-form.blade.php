<div wire:ignore.self class="modal fade" id="updateCreateModal" tabindex="-1" role="dialog" aria-labelledby="updateCreateModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h6 class="modal-title m-0" id="updateCreateModalTitle">
                    @if (!$toggleForm)
                        New Service
                    @else
                        Edit Service
                    @endif
                </h6>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()" aria-label="Close"></button>
            </div><!--end modal-header-->     
            
            <form  @if ($toggleForm) wire:submit.prevent="updateFmsService" @else wire:submit.prevent="storeFmsService" @endif >             
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label required">Name</label>
                            <input type="text" id="name" class="form-control" name="name" required
                                wire:model.defer="name">
                            @error('name')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="sku" class="form-label required">Sku</label>
                            <input type="text" id="sku" class="form-control" name="sku" required
                                wire:model.defer="sku">
                            @error('sku')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="sale_price" class="form-label required">Sale Price</label>
                            <input type="number" step="any" id="sale_price" class="form-control" name="sale_price" required
                                wire:model.defer="sale_price">
                            @error('sale_price')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>                        
                                 
                        <div class="mb-3 col-md-4">
                            <label for="currency_id" class="form-label required">{{ __('Currency') }}</label>
                            <select class="form-select select2" id="currency_id" wire:model.lazy="currency_id">
                                <option selected value="">Select</option>
                                <option value=''>None</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{$currency->id}}">{{$currency->name}} ({{$currency->code}})</option>
                                @endforeach
                            </select>
                            @error('currency_id')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
  
                        <div class="mb-3 col-md-4">
                            <label for="category_id" class="form-label required">{{ __('Category') }}</label>
                            <select class="form-select select2" id="category_id" wire:model.lazy="category_id">
                                <option selected value="">Select</option>
                                <option value=''>None</option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                                 
                        <div class="mb-3 col-md-4">
                            <label for="is_purchased" class="form-label required">{{ __('Is Purchased') }}</label>
                            <select class="form-select select2" id="is_purchased" wire:model.lazy="is_purchased">
                                <option selected value="">Select</option>
                                <option value='1'>Yes</option>
                                <option value='0'>No</option>
                            </select>
                            @error('is_purchased')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        @if ($is_purchased == 1)
                            <div class="mb-3 col-md-3">
                                <label for="cost_price" class="form-label required">Cost Price</label>
                                <input type="number" step="any" id="cost_price" class="form-control" name="cost_price" required
                                    wire:model.defer="cost_price">
                                @error('cost_price')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>   
                            {{-- <div class="mb-3 col-md-3">
                                <label for="supplier_id" class="form-label required">Supplier</label>
                                <input type="number" step="any" id="supplier_id" class="form-control" name="supplier_id" required
                                    wire:model.defer="supplier_id">
                                @error('supplier_id')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>                            --}}
                        @endif

                        
                        <div class="mb-3 col-md-3">
                            <label for="is_taxable" class="form-label required">{{ __('Is taxable') }}</label>
                            <select class="form-select select2" id="is_taxable" wire:model.lazy="is_taxable">
                                <option selected value="">Select</option>
                                <option value='1'>Yes</option>
                                <option value='0'>No</option>
                            </select>
                            @error('is_taxable')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        @if ($is_taxable==1)
                            <div class="mb-3 col-md-3">
                                <label for="tax_rate" class="form-label required">Tax Rate</label>
                                <input type="text" id="tax_rate" class="form-control" name="tax_rate" required
                                    wire:model.defer="tax_rate">
                                @error('tax_rate')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                        <div class="mb-3 col-md-3">
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
                            <label for="description" class="form-label required">{{ __('public.description') }}</label>
                            <textarea name="description" wire:model.defer='description' id="" class="form-control"></textarea>
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