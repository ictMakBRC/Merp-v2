<div class="card"  x-cloak x-show="create_new">
    <div class="card-body">

        <div class="row">
            <div class="col-lg-6">
                <div>
                    <h4 class="header-title mb-3 text- text-center"> General item
                        Information</h4>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="subCategory" class="form-label">Category</label>
                    <select name="category_id" id="subunit" onchange="makeCode()"
                        wire:model.lazy="category_id" class="form-control">
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
                <div class="mb-3">
                    <label for="item_name" class="form-label">Item Name</label>
                    <input type="text" id="item_name" class="form-control"
                        name="item_name" wire:model.lazy="item_name" required>
                    @error('item_name')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="sku" class="form-label">Item sku</label>
                    <input type="text" id="item_code" class="form-control"
                        name="sku" wire:model.differ="sku" required>
                    @error('sku')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="cost_price" class="form-label">Cost price</label>
                    <input type="text" id="cost_price" class="form-control"
                        name="cost_price" wire:model.lazy="cost_price" required>
                    @error('cost_price')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="uom_id" class="form-label">UOM</label>
                    <select class="form-select " id="uom_id" name="uom_id"
                        wire:model.lazy="uom_id" required>
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
                <div class="input-group">
                    <label for="">Expires</label>? &nbsp
                    &nbsp<input type="checkbox" id="switch1" wire:model.lazy="expires"
                        name="expires" checked data-switch="bool" />
                    <label for="switch1" data-on-label="True"
                        data-off-label="False"></label>
                </div>


            </div>
            <!-- end col -->

            <div class="col-lg-6">
                <div>
                    <h4 class="header-title mb-3 text-center"> Item Details</h4>
                </div>
                <hr>


                <div class="mb-3">
                    <label for="max_qty" class="form-label">Max Qty</label>
                    <input class="form-control" id="max_qty" type="text"
                        wire:model.lazy="max_qty" name="max_qty" required>
                    @error('max_qty')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="min_qty" class="form-label">Min Qty</label>
                    <input class="form-control" id="min_qty" type="text"
                        name="min_qty" wire:model.lazy="min_qty" required>
                    @error('min_qty')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="description" class="form-label">Description on Purchase
                        transactions</label>
                    <textarea class="form-control" name="description" wire:model.lazy="description" required></textarea>
                    @error('description')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="date_added" class="form-label">As of</label>
                    <input class="form-control" id="date_added" type="date"
                        name="date_added" wire:model="date_added" required>
                    @error('date_added')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-grid mb-3 text-center">

                </div>
            </div> <!-- end col -->

        </div>
        <!-- end row-->


    </div><!-- end card body-->
</div><!-- end card -->