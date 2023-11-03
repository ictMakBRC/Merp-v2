<div>
    @if (!$items_list->where('bidder_unit_cost', null)->isEmpty())
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="card-title">{{ __('Best Bidder Pricing') }} | <span>Total Cost:
                            ({{ $request->currency->code }})</span> <strong
                            class="text-danger">@moneyFormat(getItemsTotalCost($request_id))</strong></h4>
                </div><!--end col-->
            </div> <!--end row-->
        </div>
        @if (requiresProcurementContract(exchangeToDefaultCurrency($request->currency_id, getItemsTotalCost($request->id))))
            <div class="alert alert-danger border-0 text-center p-2 m-2" role="alert">
                {{ __('You will need to issue a contract to the provider and upload the same using the support documents Tab because the bidder amount is higher than') }}
                @moneyFormat(getProcurementCategorization(exchangeToDefaultCurrency($request->currency_id, getItemsTotalCost($request->id)))->contract_requirement_threshold)
            </div>
        @else
            <div class="alert alert-warning border-0 text-center p-2 m-2" role="alert">
                {{ __('You will need to issue an LPO to the provider and upload the same via the support documents Tab') }}
            </div>
        @endif
        <div class="table-responsive scrollable-div">
            <table class="table mb-0 w-100 table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>{{ __('Description') }}</th>
                        <th>{{ __('Quantity Requested') }}</th>
                        <th>{{ __('Estimated Unit Price') }}</th>
                        <th>{{ __('Estimated Total') }}</th>
                        <th>{{ __('Bidder Unit Price') }}</th>
                        <th>{{ __('Bidder Total') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items_list->where('bidder_unit_cost', null) as $key => $item)
                        <tr>
                            <td>
                                <button wire:click="activateItem({{ $item->id }})"
                                    class="btn btn btn-sm btn-outline-info action-icon"> {{ $key + 1 }}<i
                                        class="ti ti-edit"></i></button>
                            </td>
                            <td>{!! nl2br(e($item->description)) !!}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->estimated_unit_cost }}</td>
                            <td>{{ $item->total_cost }}</td>
                            @if ($item->id === $item_id)
                                {{-- <form> --}}
                                <td>
                                    <input type="number" class="form-control" wire:model.lazy="bidder_unit_cost"
                                        step="0.01">
                                    @error('bidder_unit_cost')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </td>

                                <td>
                                    <input type="number" class="form-control" wire:model.lazy="bidder_total_cost"
                                        readonly>
                                    @error('bidder_total_cost')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <x-button class="btn btn-success"
                                        wire:click="storeBidderPrice({{ $item->id }})">{{ __('public.save') }}</x-button>
                                </td>
                                {{-- </form> --}}
                            @else
                                <td colspan="4">
                                    <div class="alert alert-info border-0 text-center" role="alert">
                                        {{ __('Please click Item to update bidder price') }}
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div> <!-- end preview-->
    @endif

    @if (!$request->items->whereNotNull('bidder_unit_cost')->isEmpty())
        <div class="table-responsive">
            <table class="table mb-0 w-100 table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>{{ __('Description') }}</th>
                        <th>{{ __('Quantity Requested') }}</th>
                        <th>{{ __('Estimated Unit Price') }}</th>
                        <th>{{ __('Estimated Total') }}</th>
                        <th>{{ __('Bidder Unit Price') }}</th>
                        <th>{{ __('Bidder Total') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($request->items->whereNotNull('bidder_unit_cost') as $key => $item)
                        <tr>
                            <td>
                                {{ $key + 1 }}
                            </td>
                            <td>{!! nl2br(e($item->description)) !!}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->estimated_unit_cost }}</td>
                            <td>{{ $item->total_cost }}</td>
                            <td>{{ $item->bidder_unit_cost }}</td>
                            <td>{{ $item->bidder_total_cost }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="6" class="text-end">Total: ({{ $request->currency->code }})</td>
                        <td>@moneyFormat(getItemsTotalCost($request_id))</td>
                    </tr>

                </tbody>
            </table>
        </div> <!-- end preview-->

    @endif
</div>
