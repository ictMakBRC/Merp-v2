<div>

    <div class="row">
        @include('livewire.procurement.requests.inc.loading-info')
        <div class="col-md-5">
            <form wire:submit.prevent="storeItem">
                <div class="row">

                    <div class="mb-3 col-md-12">
                        <label for="item_name" class="form-label required">{{ __('Item Name') }}</label>
                        <input type="text" id="item_name" class="form-control" wire:model.defer="item_name">
                        @error('item_name')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="description" class="form-label required">{{ __('Description') }}</label>
                        <textarea type="text" id="description" class="form-control" wire:model.defer="description" rows="3"></textarea>
                        @error('description')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="quantity" class="form-label">{{ __('Quantity') }}</label>
                        <input type="number" id="quantity" class="form-control" wire:model.defer="quantity"
                            step="0.01">
                        @error('quantity')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="unit_of_measure" class="form-label">{{ __('Unit of Measure') }}</label>
                        <input type="text" id="unit_of_measure" class="form-control"
                            wire:model.defer="unit_of_measure">
                        @error('unit_of_measure')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="estimated_unit_cost" class="form-label">{{ __('Est unit cost') }}</label>
                        <input type="number" id="estimated_unit_cost" class="form-control"
                            wire:model.lazy="estimated_unit_cost" step="0.01">
                        @error('estimated_unit_cost')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="total_cost" class="form-label">{{ __('Total Cost') }}</label>
                        <input type="number" id="total_cost" class="form-control" wire:model.defer="total_cost"
                            step="0.01" readonly>
                        @error('total_cost')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <x-button type="submit" class="btn btn-success">{{ __('public.save') }}</x-button>
                </div>
            </form>
        </div>

        <div class="col-md-7">
            @if (!$items->isEmpty())
                <div class="tab-content scrollable-div">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 w-100 sortable border">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>{{ __('Item Name') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th>{{ __('Estimated Unit Cost') }}</th>
                                    <th>{{ __('Total Cost') }}</th>
                                    <th>{{ __('public.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->item_name??'N/A' }}</td>
                                        <td>{!! nl2br(e($item->description)) !!}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>@moneyFormat($item->estimated_unit_cost)</td>
                                        <td>@moneyFormat($item->total_cost)</td>

                                        <td>
                                            <button class="btn btn-sm btn-outline-danger"
                                                wire:click="deleteItem({{ $item->id }})" title="{{ __('public.delete') }}">
                                                <i class="ti ti-x fs-18"></i></button>
                                        </td>
                                    </tr>
                                    
                                @endforeach
                                <tr>
                                    <td colspan="5" class="text-end">Total</td>
                                    <td>@moneyFormat($items->sum('total_cost'))</td>

                                </tr>
                            </tbody>
                        </table>
                    </div> <!-- end preview-->

                </div> <!-- end tab-content-->
            @else<div class="alert border-0 border-start border-5 border-warning alert-dismissible fade show py-2">
                    <div class="d-flex align-items-center">
                        <div class="font-35 text-warning"><i class='bx bx-primary-circle'></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 text-warning">{{ __('Items') }}</h6>
                            <div>{{ __('public.not_found') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
