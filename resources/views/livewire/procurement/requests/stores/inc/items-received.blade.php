@if (!$request->items->where('received_status', true)->isEmpty())
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="card-title">{{ __('Items Received') }}</h4>
            </div><!--end col-->
            <div class="col-auto">
                <div class="dropdown">
                    <a href="#" class="btn btn-sm btn-outline-light dropdown-toggle" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        {{-- <i class="las la-menu align-self-center text-muted icon-xs"></i> --}}
                        <i class="mdi mdi-dots-horizontal text-muted"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#"><i class="ti ti-file-export me-1"></i>Export</a>
                    </div>
                </div>
            </div><!--end col-->
        </div> <!--end row-->
    </div>

    <div class="table-responsive scrollable-di">
        <table class="table mb-0 w-100 table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>{{__('Item Name')}}</th>
                    <th>{{ __('Description') }}</th>
                    <th>{{ __('Quantity Requested') }}</th>
                    <th>{{ __('Estimated Unit Price') }}</th>
                    <th>{{ __('Estimated Total') }}</th>
                    <th>{{ __('Quantity Delivered') }}</th>
                    <th>{{ __('Bidder Unit Price') }}</th>
                    <th>{{ __('Bidder Total') }}</th>
                    <th>{{ __('Quality') }}</th>
                    {{-- <th>{{ __('Total Cost') }}</th> --}}
                    <th>{{ __('Comment') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($request->items->where('received_status', true) as $key => $item)
                    <tr>
                        <td>
                            {{ $key + 1 }}
                        </td>
                        <td>{{$item->item_name??'N/A'}}</td>
                        <td>{!! nl2br(e($item->description)) !!}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>@moneyFormat($item->estimated_unit_cost)</td>
                        <td>@moneyFormat($item->total_cost)</td>
                        <td>
                            {{ $item->quantity_delivered??0 }}
                        </td>
                        <td>@moneyFormat($item->bidder_unit_cost??0)</td>
                        <td>@moneyFormat($item->bidder_total_cost??0)</td>
                        <td>
                            <span
                                class="badge bg-{{ getProcurementRequestStatusColor($item->quality) }}">{{ $item->quality }}</span>
                        </td>
                        {{-- <td>@moneyFormat($item->total_cost)</td> --}}
                        <td>
                            {{ $item->comment }}
                        </td>
                    </tr>
                    
                @endforeach
                <tr>
                    <td colspan="4" class="text-end">Total: ({{ $request->currency->code }})</td>
                    <td>@moneyFormat($request->items->where('received_status', true)->sum('total_cost'))</td>
                    <td colspan="2"></td>
                    {{-- <td></td> --}}
                    <td>@moneyFormat($request->items->where('received_status', true)->sum('bidder_total_cost'))</td>

                </tr>
            </tbody>
        </table>
    </div> <!-- end preview-->

@endif
