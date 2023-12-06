<div>
    <x-report-layout>
        <table class="table table-striped mb-0 w-100 table-bordered">
            <thead>
                <tr>
                    <th>To: {{ $request->providers->first()->name }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-start">
                        <strong class="text-inverse">{{ __('Address') }}:
                        </strong>{{ $request->providers->first()->full_address ?? 'N/A' }}<br>
                        <strong class="text-inverse">{{ __('Email') }}:
                        </strong>{{ $request->providers->first()->email }}<br>
                        <strong class="text-inverse">{{ __('Contact') }}:
                        </strong>{{ $request->providers->first()->phone_number }}<br>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="card-header text-center">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="card-title">{{ __('REQUEST FOR QUOTATION (RFQ)') }}</h4>
                </div><!--end col-->

                <div class="col">
                    <h4 class="card-title">Reference #<strong class="text-danger">{{ $request->reference_no }}</strong>
                    </h4>
                </div><!--end col-->
            </div> <!--end row-->
        </div>
        <div class="tab-content">
            <div class="table-responsive">
                <table class="table table-striped mb-0 w-100 table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>{{ __('Item name') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('Unit') }}</th>
                            <th>{{ __('Quantity') }}</th>
                            <th>{{ __('Estimated Cost') }}</th>
                            <th>{{ __('Total Cost') }}</th>
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
                                <td>@moneyFormat($item->estimated_unit_cost)</td>
                                <td>@moneyFormat($item->total_cost)</td>

                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2"><strong class="text-dange">Submit Response to:
                                </strong>{{ $request->approvals->where('step', 'Procurement')->first()->approver->employee->email }}
                            </td>
                            <td colspan="1" class="text-start">Closing date: (<strong
                                    class="text-danger">@formatDate($request->bid_return_deadline)</strong>)</td>
                            <td colspan="3" class="text-end">Total: ({{ $request->currency->code }})</td>
                            <td><strong class="text-danger">@moneyFormat($request->items->sum('total_cost'))</strong></td>
                        </tr>
                        <tr>
                            <td colspan="7" class="text-start">
                                <strong class="text-inverse">{{ __('Member of user Department') }}:
                                </strong><br>
                                <strong class="text-inverse">{{ __('Signature') }}:
                                </strong>{{ $request->approvals->where('step', 'Department')->first()->approver->employee->signature ?? 'N/A' }}<br>
                                <strong class="text-inverse">{{ __('Date') }}:
                                </strong>@formatDate($request->updated_at)<br>
                                <strong class="text-inverse">{{ __('Name') }}:
                                </strong>{{ $request->approvals->where('step', 'Department')->first()->approver->employee->fullName }}<br>
                                <strong class="text-inverse">{{ __('Designation') }}:
                                </strong>{{ $request->approvals->where('step', 'Department')->first()->approver->employee->designation->name }}<br>
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

                        {{-- @if ($request->step_order == 6) --}}
                        <x-button class="btn btn-de-success btn-sm"
                            wire:click="sendRequestForQuotation({{ $request->id }})"
                            onclick="return confirm('Are you sure you want to proceed?');">Send to
                            Providers</x-button>
                        {{-- @endif --}}

                        <a href="javascript:window.print()" class="btn btn-de-info btn-sm">Print</a>
                        <a href="{{ route('procurement-office-panel') }}" class="btn btn-de-primary btn-sm">Back to
                            list</a>
                    </div>
                </div><!--end col-->
            </div><!--end row-->

        </x-slot>
    </x-report-layout>
</div>
