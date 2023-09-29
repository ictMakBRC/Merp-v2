<div>

    <div class="row">


        <div class="col-md-12">
            @json($items)
            {{-- @if (!$items->isEmpty()) --}}
                <div class="tab-content scrollable-di">
                    <div class="table-responsive">
                        <table class="table mb-0 w-100 table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Quantity Requested') }}</th>
                                    <th>{{ __('Received?') }}</th>
                                    <th>{{ __('Quantity Delivered') }}</th>
                                    <th>{{ __('Quality') }}</th>
                                    <th>{{ __('Comment') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{!! nl2br(e($item['description'])) !!}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                   
                                    <td>
                                        <select class="form-select" wire:model="items.{{ $key }}.received_status">
                                            <option value="">Select</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        @error("items.{{ $key }}.received_status") <div class="text-danger text-small">{{ $message }}</div> @enderror
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" wire:model.lazy="items.{{ $key }}.quantity_delivered" step="0.01">
                                        @error("items.{{ $key }}.quantity_delivered") <div class="text-danger text-small">{{ $message }}</div> @enderror
                                    </td>
                                    <td>
                                        <select class="form-select" wire:model="items.{{ $key }}.quality">
                                            <option value="high">High</option>
                                            <option value="medium">Medium</option>
                                            <option value="low">Low</option>
                                        </select>
                                        @error("items.{{ $key }}.quality") <div class="text-danger text-small">{{ $message }}</div> @enderror
                                    </td>
                                    <td>
                                        <textarea type="text" class="form-control" wire:model.lazy="items.{{ $key }}.comment"></textarea>
                                    </td>
                                </tr>
                            @endforeach
                           
                            </tbody>
                        </table>
                        <div class="modal-footer">
                            <x-button class="btn btn-success" wire:click="saveChanges">{{ __('public.save') }}</x-button>
                        </div>
                    </div> <!-- end preview-->

                </div> <!-- end tab-content-->
            {{-- @else<div class="alert border-0 border-start border-5 border-warning alert-dismissible fade show py-2">
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
            @endif --}}
        </div>
    </div>
</div>
