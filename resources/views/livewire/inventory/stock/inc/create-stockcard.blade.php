<div class="row">
    <div class="col-md-12">
        <form
            @if (!$toggleForm) wire:submit.prevent="store"
    @else
    wire:submit.prevent="updateData" @endif>
            <div class="row">

                <div class="mb-3 col-md-2">
                    <div class="form-group">
                        <label for="transaction_date" class="form-label required">{{ __('transaction_date') }}</label>
                        <input type="date" wire:model.defer="transaction_date" class="form-control"
                            max="{{ date('Y-m-d') }}">
                        @error('transaction_date')
                            <span class="text-danger error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 col-md-2">
                    <div class="form-group">
                        <label for="transaction_type" class="form-label required">{{ __('transaction_type') }}</label>
                        <select class="form-select" wire:model.lazy='transaction_type'>

                            <option value="">{{ __('select') }}...</option>
                            <option value="Issue Stock"> {{ __('issue_stock') }} </option>
                            {{-- <option value="Receive Stock"> {{ __('receive_stock') }}</option> --}}
                            <option value="Physical Count"> {{ __('physical_count') }}</option>
                            <option value="Loss / Adjustment">{{ __('losses_adjustments') }}</option>
                        </select>

                        @error('transaction_type')
                            <span class="text-danger error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                @if ($transaction_type == 'Receive Stock')
                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="source_or_destination"
                                class="form-label required">{{ __('source_or_destination') }}</label>

                            <select class="form-select" wire:model.defer='source_or_destination'>
                                <option value="">{{ __('select') }}...</option>
                                @foreach ($distributors as $value)
                                    <option value="{{ $value->name }}">{{ $value->name }} </option>
                                @endforeach
                            </select>
                            @error('source_or_destination')
                                <span class="text-danger error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                @endif

                <div class="mb-3 col-md-4">
                    <div class="form-group">
                        <label for="commodity_id" class="form-label required">{{ __('commodity') }} </label>

                        <select class="form-select" wire:model.lazy='commodity_id'>
                            <option value="">{{ __('select') }}... </option>
                            @foreach ($items as $value)
                                <option value={{ $value->id }}>{{ $value->name }}</option>
                            @endforeach
                        </select>
                        @error('commodity_id')
                            <span class="text-danger error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                @if ($transaction_type == 'Issue Stock' || $transaction_type == 'Receive Stock')
                    <div class="mb-3 col-md-4">
                        <div class="form-group">
                            <label for="batch_number" class="form-label required">{{ __('batch_number') }}</label>

                            @if ($transaction_type == 'Issue Stock')
                                <select class="form-select" wire:model.lazy='batch_number'>
                                    <option value="">{{ __('select') }}... </option>
                                    @foreach ($batches as $value)
                                        <option value="{{ $value->batch_number }}">{{ $value->batch_number }}-(
                                            {{ $value->expiry_date }} )</i></option>
                                    @endforeach
                                </select>
                            @else
                                <input type="text" wire:model.defer="batch_number" class="form-control">
                            @endif

                            @error('batch_number')
                                <span class="text-danger error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="mb-3 col-md-2">
                        <div class="form-group">
                            <label for="expiry_date" class="form-label">{{ __('expiry_date') }}</label>

                            @if ($transaction_type == 'Issue Stock')
                                <input type="date" wire:model.defer="expiry_date" class="form-control"
                                    min="{{ date('Y-m-d') }}" readonly="true">
                            @elseif($transaction_type == 'Loss / Adjustment')
                                <input type="date" wire:model.defer="expiry_date" class="form-control">
                            @else
                                <input type="date" wire:model.defer="expiry_date" class="form-control"
                                    min="{{ date('Y-m-d') }}">
                            @endif
                        </div>
                    </div>
                @endif

                <div class="mb-3 col-md-2">
                    <div class="form-group">
                        <label for="quantity" class="form-label required">
                            @if ($transaction_type == 'Receive Stock')
                                {{ __('quantity_received') }}
                            @elseif($transaction_type == 'Physical Count')
                                {{ __('quantity_confirmed') }}
                            @elseif($transaction_type == 'Issue Stock')
                                {{ __('quantity_issued') }}
                            @else
                                {{ __('quantity') }}
                            @endif
                        </label>
                        <input type="number" wire:model.lazy="quantity" class="form-control">
                        @error('quantity')
                            <span class="text-danger error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                @if ($transaction_type == 'Issue Stock' || $transaction_type == 'Receive Stock')
                    <div class="mb-3 col-md-2">
                        <div class="form-group">
                            <label for="batch_balance" class="form-label">{{ __('batch_balance') }}</label>
                            <input type="number" wire:model="batch_balance" class="form-control" readonly="true">
                        </div>
                    </div>
                @endif

                <div class="mb-3 col-md-2">
                    <div class="form-group">

                        <label for="balance_on_hand" class="form-label">
                            @if ($transaction_type == 'Physical Count')
                                {{ __('expected_quantity') }}
                            @else
                                {{ __('balance_on_hand') }}
                            @endif
                        </label>
                        <input type="number" wire:model.lazy="balance_on_hand" class="form-control" readonly="true">
                    </div>
                </div>

                @if (in_array($transaction_type, ['Physical Count']))
                    <div class="mb-3 col-md-2">
                        <div class="form-group">
                            <label for="discrepancy" class="form-label">{{ __('discrepancy') }}</label>
                            <input type="number" class="form-control" wire:model.defer="discrepancy" readonly="true">
                        </div>
                    </div>
                @endif

                <div class="mb-3 col-md-4">
                    <div class="form-group">
                        <label for="comment" class="form-label">{{ __('comment') }}</label>
                        <textarea class="form-control" wire:model.defer="comment"></textarea>
                    </div>
                </div>

                <div class="mb-3 col-md-2">
                    <div class="form-group">
                        <label for="storage_bin" style="color:red"
                            class="form-label">{{ __('storage_bin') }}</label>
                        <input type="text" class="form-control" wire:model.defer="storage_bin" readonly="true">
                    </div>
                </div>

                <div class="mb-3 col-md-2">
                    <div class="form-group">
                        <label for="storage_type" style="color:red"
                            class="form-label">{{ __('storage_type') }}</label>
                        <input type="text" class="form-control" wire:model.defer="storage_type" readonly="true">
                    </div>
                </div>

                <div class="mb-3 col-md-2">
                    <div class="form-group">
                        <label for="storage_section" style="color:red"
                            class="form-label">{{ __('storage_section') }}</label>
                        <input type="text" class="form-control" wire:model.defer="storage_section"
                            readonly="true">
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                @if (!$toggleForm)
                    <x-button class="btn-success">{{ __('save') }}</x-button>
                @else
                    <x-button class="btn-success">{{ __('update') }}</x-button>
                @endif
            </div>
        </form>
    </div>

</div>
