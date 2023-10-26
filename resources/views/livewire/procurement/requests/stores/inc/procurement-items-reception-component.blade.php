<div>
    @if (!$request->items->where('received_status', false)->isEmpty())
        <div class="table-responsive scrollable-div">
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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($request->items->where('received_status', false) as $key => $item)
                        <tr>
                            <td>
                                <button wire:click="activateItem({{ $item->id }})"
                                    class="btn btn btn-sm btn-outline-info action-icon"> {{ $key + 1 }}<i
                                        class="ti ti-edit"></i></button>
                            </td>
                            <td>{!! nl2br(e($item['description'])) !!}</td>
                            <td>{{ $item['quantity'] }}</td>
                            @if ($item->id === $item_id)
                                {{-- <form> --}}
                                <td>
                                    <div class="mb-3 row">
                                        <div class="col-md-9">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="received_status"
                                                    id='received_status1' wire:model='received_status' checked
                                                    value="0">
                                                <label class="form-check-label" for="received_status1">
                                                    No
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="received_status"
                                                    id='received_status2' wire:model='received_status' value="1">
                                                <label class="form-check-label" for="received_status2">
                                                    Yes
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @error('received_status')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" class="form-control" wire:model.lazy="quantity_delivered"
                                        step="0.01">
                                    @error('quantity_delivered')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </td>

                                <td>
                                    <div class="mb-3 row">
                                        <div class="col-md-9">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="quality"
                                                    id="quality1" wire:model='quality' checked value="How">
                                                <label class="form-check-label" for="quality1">
                                                    Low
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="quality"
                                                    id="quality2" wire:model='quality' value="Average">
                                                <label class="form-check-label" for="quality2">
                                                    Average
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="quality"
                                                    id="quality3" wire:model='quality' value="High">
                                                <label class="form-check-label" for="quality3">
                                                    High
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @error('quality')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </td>

                                <td>
                                    <textarea type="text" class="form-control" wire:model.lazy="comment"></textarea>
                                </td>

                                <td>
                                    <x-button class="btn btn-success"
                                        wire:click="storeItemReceptionInformation({{ $item->id }})">{{ __('public.save') }}</x-button>
                                </td>
                                {{-- </form> --}}
                            @else
                                <td colspan="5">
                                    <div class="alert alert-info border-0 text-center" role="alert">
                                        {{ __('Please click Item to receive') }}
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div> <!-- end preview-->
    @endif

    @include('livewire.procurement.requests.stores.inc.items-received')
</div>
