<div class="card" x-cloak x-show="create_new">
    <form @if ($toggleForm) wire:submit.prevent="updateItem" @else wire:submit.prevent="storeItem" @endif > 
        <div class="card-body">
            <div class="row">
                <div class="mb-3 col-md-3">
                    <label for="subCategory" class="form-label">Category</label>
                    <select name="category_id" id="subunit" onchange="makeCode()" wire:model.lazy="category_id"
                        class="form-control">
                        <option value="">Select</option>
                        @if (count($categories) > 0)
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('category_id')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-md-3">
                    <label for="name" class="form-label">Item Name</label>
                    <input type="text" id="name" class="form-control" name="name"
                        wire:model.lazy="name" required>
                    @error('name')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-2">
                    <label for="sku" class="form-label">Item sku</label>
                    <input type="text" id="sku" class="form-control" name="sku" wire:model="sku"
                        required>
                    @error('sku')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-2">
                    <label for="cost_price" class="form-label">Cost price</label>
                    <input type="text" id="cost_price" class="form-control" name="cost_price"
                        wire:model.lazy="cost_price" required>
                    @error('cost_price')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-md-2">
                    <label for="uom_id" class="form-label">UOM</label>
                    <select class="form-select " id="uom_id" name="uom_id" wire:model.lazy="uom_id" required>
                        <option value="">Select</option>
                        @if (count($uoms) > 0)
                            @foreach ($uoms as $uom)
                                <option value="{{ $uom->id }}">{{ $uom->name }}
                                </option>
                            @endforeach
                        @endif
                        @error('uom_id')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </select>
                </div>

                <div class="mb-3 col-md-3">
                    <label for="max_qty" class="form-label">Max Qty</label>
                    <input class="form-control" id="max_qty" type="text" wire:model.lazy="max_qty" name="max_qty"
                        required>
                    @error('max_qty')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-3">
                    <label for="min_qty" class="form-label">Min Qty</label>
                    <input class="form-control" id="min_qty" type="text" name="min_qty" wire:model.lazy="min_qty"
                        required>
                    @error('min_qty')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-md-2">
                    <label for="uom_id" class="form-label">Expires?</label>
                    <select class="form-select " id="expires" name="expires" wire:model.lazy="expires" required>
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                        @error('expires')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </select>
                </div>

                <div class="mb-3 col">
                    <label for="description" class="form-label">Description on Purchase
                        transactions</label>
                    <textarea class="form-control" name="description" wire:model.lazy="description" required></textarea>
                    @error('description')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>


            </div>
            <!-- end row-->


        </div><!-- end card body-->
        <div class="modal-footer">
            <x-button class="btn btn-success">{{ __('public.save') }}</x-button>
        </div>
    </form>
</div><!-- end card -->
