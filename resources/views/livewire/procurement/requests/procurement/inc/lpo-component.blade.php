<div>
    <x-report-layout>
        <h5 class="text-start mx-5 border-bottom">M/S : {{ $request->bestBidders->first()->name }}</h5>
        <div class="card-header text-center">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="card-title">{{ __('LOCAL PURCHASE ORDER (LPO)') }}</h4>
                </div><!--end col-->
                <div class="col">
                    <h4 class="card-title">Serial No. <strong class="text-danger">{{ $request->lpo_no }}</strong></h4>
                </div><!--end col-->
                <div class="col">
                    <h4 class="card-title">Reference #<strong class="text-danger">{{ $request->reference_no }}</strong>
                    </h4>
                </div><!--end col-->
            </div> <!--end row-->
        </div>
        <div class="tab-content">
            <div class="text-center mt-2">
                <p>Based on your proforma invoice number <strong
                        class="text-danger">#{{ $request->bestBidders->first()->pivot->invoice_no }}</strong> of date
                    <strong class="text-danger">@formatDate($request->bestBidders->first()->pivot->invoice_date)</strong>, Please supply us the following
                    goods/services
                </p>
            </div>
            <div class="table-responsive">
                <table class="table table-striped mb-0 w-100 table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>{{ __('ITEM NAME') }}</th>
                            <th>{{ __('PARTICULAR(S)') }}</th>
                            <th>{{ __('UNIT') }}</th>
                            <th>{{ __('QUANTITY') }}</th>
                            <th>{{ __('RATE') }}</th>
                            <th>{{ __('COST') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($request->items as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->item_name ?? 'N/A' }}</td>
                                <td>{!! nl2br(e($item->description)) !!}</td>
                                <td>{{ $item->unit_of_measure }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>@moneyFormat($item->bidder_unit_cost)</td>
                                <td>@moneyFormat($item->bidder_total_cost)</td>

                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" class="text-start">LPO Valid until: (<strong
                                    class="text-danger">@formatDate($request->delivery_deadline)</strong>)</td>
                            <td colspan="3" class="text-end">Total: ({{ $request->currency->code }})</td>
                            <td><strong class="text-danger">@moneyFormat($request->items->sum('bidder_total_cost'))</strong></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="2" class="text-start">
                                <strong class="text-inverse">{{ __('Prepared By') }}:
                                </strong><br>
                                <strong class="text-inverse">{{ __('Signature') }}:
                                </strong>{{ $request->approvals->where('step', 'Procurement')->first()->approver?->employee?->signature ?? 'N/A' }}<br>
                                <strong class="text-inverse">{{ __('Date') }}:
                                </strong>@formatDate($request->updated_at)<br>
                                <strong class="text-inverse">{{ __('Name') }}:
                                </strong>{{ $request->approvals->where('step', 'Procurement')->first()->approver?->employee?->fullName }}<br>
                                <strong class="text-inverse">{{ __('Designation') }}:
                                </strong>{{ $request->approvals->where('step', 'Procurement')->first()->approver?->employee?->designation?->name }}<br>
                            </td>
                            <td colspan="2" class="text-start">
                                <strong class="text-inverse">{{ __('Checked By') }}:
                                </strong><br>
                                <strong class="text-inverse">{{ __('Signature') }}:
                                </strong>{{ $request->approvals->where('step', 'Department')->first()->approver?->employee?->signature ?? 'N/A' }}<br>
                                <strong class="text-inverse">{{ __('Date') }}:
                                </strong>@formatDate($request->updated_at)<br>
                                <strong class="text-inverse">{{ __('Name') }}:
                                </strong>{{ $request->approvals->where('step', 'Department')->first()->approver?->employee?->fullName }}<br>
                                <strong class="text-inverse">{{ __('Designation') }}:
                                </strong>{{ $request->approvals->where('step', 'Department')->first()->approver?->employee?->designation?->name }}<br>
                            </td>
                            <td colspan="2" class="text-start">
                                <strong class="text-inverse">{{ __('Approved By') }}:
                                </strong><br>
                                <strong class="text-inverse">{{ __('Signature') }}:
                                </strong>{{ $request->approvals->where('step', 'Operations')->first()->approver?->employee?->signature ?? 'N/A' }}<br>
                                <strong class="text-inverse">{{ __('Date') }}:
                                </strong>@formatDate($request->updated_at)<br>
                                <strong class="text-inverse">{{ __('Name') }}:
                                </strong>{{ $request->approvals->where('step', 'Operations')->first()->approver?->employee?->fullName }}<br>
                                <strong class="text-inverse">{{ __('Designation') }}:
                                </strong>{{ $request->approvals->where('step', 'Operations')->first()->approver?->employee?->designation?->name }}<br>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <x-slot:action>
            <div class="row d-flex justify-content-center d-print-none">
                <div class="col-lg-12 col-xl-12">
                    <div class="float-end d-print-none mt-2 mt-md-0 mb-2">
                        
                        @if ($request->step_order == 6)
                            <x-button class="btn btn-de-success btn-sm"
                                wire:click="sendLocalPurchaseOrder({{ $request->id }})"
                                onclick="return confirm('Are you sure you want to proceed?');">Send to
                                Provider</x-button>
                        @endif

                        @if ($request->net_payment_terms > 0)
                            <x-button class="btn btn-de-success btn-sm"
                                wire:click="initiatePaymentRequest({{ $request->id }})"
                                onclick="return confirm('Are you sure you want to proceed?');">Initial Payment
                                Request</x-button>
                        @endif

                        <a href="javascript:window.print()" class="btn btn-de-info btn-sm">Print</a>
                        <a href="{{ route('procurement-office-panel') }}" class="btn btn-de-primary btn-sm">Back to
                            list</a>
                    </div>
                </div><!--end col-->
            </div><!--end row-->

        </x-slot>
    </x-report-layout>

</div>
