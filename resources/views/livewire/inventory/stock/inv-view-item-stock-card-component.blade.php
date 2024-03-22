<div>
    <div class="row" x-data="{ filter_data: @entangle('filter'), create_new: @entangle('createNew') }">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    Item Stock card (<span
                                        class="text-danger fw-bold">{{ $stockcards->total() }}</span>)
                                    @include('livewire.layouts.partials.inc.filter-toggle')
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                      <x-table-utilities>
                        <div class="mb-1 col">
                            <label for="orderBy" class="form-label">OrderBy</label>
                            <select wire:model="orderBy" class="form-select">
                                <option type="date">Date</option>
                                <option type="id">Latest</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-2">
                            <label for="from_date" class="form-label">From Date</label>
                            <input id="from_date" type="date" class="form-control"
                                wire:model.lazy="from_date">
                        </div>

                        <div class="mb-3 col-md-2">
                            <label for="to_date" class="form-label">To Date</label>
                            <input id="to_date" type="date" class="form-control" wire:model.lazy="to_date">
                        </div>
                    </x-table-utilities>
                        <table class="table table-striped table-bordered mb-0 w-100 sortable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('transaction_date') }}</th>
                                    <th>{{ __('commodity') }}</th>
                                    <th>{{ __('voucher_number') }}</th> 
                                    <th>{{ __('batch_or_lot_number') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                     <th>{{ __('discrepancy') }}</th> 
                                    {{-- <th>{{ __('qunatity_in_out') }}</th> --}}
                                    <th title="{{ __('losses_adjustments') }}">L/A(-/+)</th>
                                    <th>{{ __('transaction_type') }}</th>
                                    <th>{{ __('expiry_date') }}</th>
                                    <th>{{ __('Initial Quantity') }}</th>
                                    <th>{{ __('Item Balance') }}</th>
                                    <th>{{ __('remarks') }}</th>
                                    <th>{{ __('initials') }}</th> 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stockcards as $key => $stockcard)
                                    <tr>
                                        <td style="white-space:">{{ $key + 1 }}</td>
                                        <td style="white-space:">@formatDate($stockcard->created_at)</td>
                                        <td style="white-space:">{{ $stockcard->departmentItem?->item?->name }}</td>
                                        <td style="white-space:">{{ $stockcard->voucher_number }}</td>
                                        <td style="white-space:">{{ $stockcard->batch_number }}</td>
                                        <td style="white-space:">{{ $stockcard->quantity }}</td>
                                        <td style="white-space:">{{ $stockcard->discrepancy }}</td>
                                        {{-- <td style="white-space:">
                                            @if ($stockcard->action == 'IN')
                                                {{ $stockcard->quantity_in }}
                                            @elseif($stockcard->action == 'OUT')
                                                {{ $stockcard->quantity_out }}
                                            @elseif($stockcard->action == 'PC')
                                                            -
                                            @endif
                                        </td> --}}
                                <td style="white-space:">{{ $stockcard->losses_adjustments }}</td>
                                <td style="white-space:">
                                    @if ($stockcard->transaction_type == 'IN')
                                        {{ __('incoming') }}
                                    @elseif($stockcard->transaction_type == 'OUT')
                                        {{ __('outgoing') }}
                                    @elseif($stockcard->action == 'PC')
                                        {{ __('physical_count') }}
                                    @elseif($stockcard->action == 'LOSS')
                                        {{ __('losses_adjustments') }}
                                    @endif
                                </td>
                                <td style="white-space:">{{ $stockcard->expiry_date??'N/A' }}</td>
                                <td style="white-space:">{{ $stockcard->initial_quantity }}</td>
                                <td style="white-space:">{{ $stockcard->item_balance }}</td>
                                <td style="white-space:">{{ $stockcard->comment }}</td>
                                <td style="white-space:">{{ $stockcard->createdBy?->name }}
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div> <!-- end preview-->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="btn-group float-end">
                                {{ $stockcards->links('vendor.livewire.bootstrap') }}
                            </div>
                        </div>
                    </div>
                </div> <!-- end tab-content-->
            </div>
        </div>
    </div>
</div>
