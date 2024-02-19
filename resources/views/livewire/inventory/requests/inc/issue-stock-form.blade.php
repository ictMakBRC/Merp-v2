<div wire:ignore.self class="modal fade" id="issueModal" tabindex="-1" data-bs-keyboard="false" aria-labelledby="issueModal"
    aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="issueModal">Full screen modal</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @if ($inventory_data?->manager_id == auth()->user()->id && $request_data?->status == 'Received')
                @if ($active_item)
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <li><strong>Item Name:</strong> {{ $active_item->departmentItem->item->name ?? '' }}
                                </li>
                                <li> <strong>Description:</strong> {{ $active_item->departmentItem->item->description }}
                                </li>
                                <li><strong>UOM</strong> {{ $active_item->departmentItem->item->uom->name ?? 'N/A' }}
                                </li>
                            </div>
                            <div class="col-6">
                                <li><strong>Brand</strong> {{ $active_item->departmentItem->brand ?? 'N/A' }}</li>
                                <li><strong>Qty Requested</strong> {{ $active_item->qty_requested }}</li>
                                <li><strong>Qty Given</strong> {{ $active_item->qty_given }}</li>
                            </div>
                            <div class="table-responsive col-12">
                                <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Entered At</th>
                                            <th>Expires At</th>
                                            <th>Store</th>
                                            <th>Batch No</th>
                                            <th>Qty Availabale</th>
                                            <th>Issue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($stock_batches) > 0)
                                            @php($i = 1)
                                            @foreach ($stock_batches as $batch)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $batch->created_at ?? '' }}</td>
                                                    <td>{{ $batch->expiry_date }}</td>
                                                    <td>{{ $batch->store->name ?? 'N/A' }}</td>
                                                    <td>{{ $batch->batch_no }}</td>
                                                    <td>{{ $batch->qyt_left }}</td>
                                                    <td>
                                                        @if ($active_batch == $batch->id)
                                                            <form
                                                                wire:submit.prevent="issueStock({{ $batch->id }})">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <label class="input-group-text"
                                                                            for="issued_amount.{{ $batch->id }}"><small class="text-info"><b>Qty to issue:</b> {{ $active_item->qty_requested-$active_item->qty_given}}</small></label>
                                                                        <input type="number" step="any"
                                                                            id="issued_amount.{{ $batch->id }}"
                                                                            required min="1"
                                                                            max="{{ $batch->qyt_left }}"
                                                                            class="form-control" name="volume"
                                                                            wire:model="issued_amount"
                                                                            placeholder="{{ $batch->qyt_left }}">
                                                                        <span class="input-group-text">
                                                                            <button class="btn btn-primary btn-sm"
                                                                                type="submit">Issue</button>
                                                                        </span>
                                                                    </div>
                                                                    @error('issued_amount.{{ $batch->id }}')
                                                                        <div class="text-danger text-small">
                                                                            {{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </form>
                                                        @else
                                                            <a href="javascript:void(0)"wire:click="$set('active_batch',{{ $batch->id }})"><i class="far fa-check-square">Issue</i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"
                            wire:click="close()">{{ __('public.close') }}</button>
                        <x-button type="submit" class="btn-success btn-sm">{{ __('Done') }}</x-button>
                    </div><!--end modal-footer-->
                @endif
            @else
                <h5 class="text-center">You can perform no action on this request</h5>
            @endif
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
</div><!--end modal-->
