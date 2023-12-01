<div class="col-md-12">
    <form
        @if (!$toggleForm) wire:submit.prevent="receiveStock"
      @else
      wire:submit.prevent="updateStock" @endif>
        <div class="row">

            <div class="mb-3 col-md-2">
                <div class="form-group">
                    <label for="transaction_date"
                        class="form-label required">{{ __('logistics.transaction_date') }}</label>
                    <input type="date" wire:model.defer="transaction_date" class="form-control"
                        max="{{ date('Y-m-d') }}">
                    @error('transaction_date')
                        <span class="text-danger error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-3 col-md-2">
                <div class="form-group">
                    <label for="source_or_destination"
                        class="form-label required">{{ __('logistics.source_or_destination') }}</label>
                    <select class="form-control" wire:model.defer='supplier_id'>
                        <option value="">{{ __('logistics.select') }}...</option>
                        <!-- <option value="Other">Other</option> -->
                        @foreach ($distributors as $value)
                            <option value="{{ $value->name }}">{{ $value->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                        <span class="text-danger error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 col-md-2">
                <div class="form-group">
                    <label for="commodity_id" class="form-label required">{{ __('logistics.commodity') }} </label>
                    <select class="form-control" wire:model.lazy='commodity_id'>
                        <option value="">{{ __('logistics.select') }}... </option>
                        @foreach ($items as $value)
                            <option value={{ $value->id }}>{{ $value->name }}</option>
                        @endforeach
                    </select>
                    @error('commodity_id')
                        <span class="text-danger error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-3 col-md-2">
                <div class="form-group">
                    <label for="batch_number" class="form-label required">{{ __('logistics.batch_number') }}</label>
                    <input type="text" wire:model.lazy="stock_batch_number" id="batch_number" class="form-control">

                    @error('stock_batch_number')
                        <span class="text-danger error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-3 col-md-2">
                <div class="form-group">
                    <label for="expiry_date" class="form-label">{{ __('logistics.expiry_date') }}</label>
                    <input type="date" wire:model.defer="stock_expiry_date" class="form-control"
                        min="{{ date('Y-m-d') }}">
                </div>
                @error('stock_expiry_date')
                    <span class="text-danger error">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3 col-md-2">
                <div class="form-group">
                    <label for="quantity" class="form-label required">
                        {{ __('logistics.quantity_received') }}
                    </label>
                    <input type="number" wire:model.defer="quantity" id="quantity" class="form-control">
                    @error('quantity')
                        <span class="text-danger error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 col-md-2">
                <div class="form-group">
                    <label for="batch_balance" class="form-label">{{ __('logistics.batch_balance') }}</label>
                    <input type="number" wire:model="batch_balance" class="form-control" readonly="true">
                </div>
            </div>
            <div class="mb-3 col-md-2">
                <div class="form-group">

                    <label for="balance_on_hand" class="form-label">
                        {{ __('logistics.balance_on_hand') }}
                    </label>
                    <input type="number" wire:model.lazy="balance_on_hand" class="form-control" readonly="true">
                </div>
            </div>



            <div class="mb-3 col-md-2">
                <div class="form-group">
                    <label for="comment" class="form-label">{{ __('logistics.comment') }}</label>
                    <textarea class="form-control" wire:model.defer="comment"></textarea>
                </div>
            </div>

            <div class="mb-3 col-md-2">
                <div class="form-group">
                    <label for="storage_type" style="color:red"
                        class="form-label">{{ __('logistics.storage_type') }}</label>
                    <input type="text" class="form-control" wire:model.defer="storage_type" readonly="true">
                </div>
            </div>

            <div class="mb-3 col-md-2">
                <div class="form-group">
                    <label for="storage_section" style="color:red"
                        class="form-label">{{ __('logistics.storage_section') }}</label>
                    <input type="text" class="form-control" wire:model.defer="storage_section" readonly="true">
                </div>
            </div>

            <div class="mb-3 col-md-2">
                <div class="form-group">
                    <label for="storage_bin" style="color:red"
                        class="form-label">{{ __('logistics.storage_bin') }}</label>
                    <input type="text" class="form-control" wire:model.defer="storage_bin" readonly="true">
                </div>
            </div>

        </div>
        <div class="modal-footer">
            @if (!$toggleForm)
                <x-button class="btn-success">{{ __('logistics.save') }}</x-button>
            @else
                <x-button class="btn-success">{{ __('logistics.update') }}</x-button>
            @endif
        </div>
    </form>
</div>
