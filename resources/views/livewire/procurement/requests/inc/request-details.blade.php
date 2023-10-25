<div class="bg-light">
    <table class="table">
        <tr>
            <td>
                <div>
                    <strong class="text-inverse">{{ __('Reference No') }}:
                    </strong>{{ $request->reference_no ?? 'N/A' }}<br>
                    <strong class="text-inverse">{{ __('Type') }}:
                    </strong>{{ $request->request_type ?? 'N/A' }}<br>
                    <strong class="text-inverse">{{ __('Source') }}:
                    </strong>{{ $request->requestable->name ?? 'N/A' }}<br>
                    <strong class="text-inverse">{{ __('Procuring Entity') }}:
                    </strong>{{ $request->procuring_entity_code ?? 'N/A' }}<br>
                    <strong class="text-inverse">{{ __('Sector') }}:
                    </strong>{{ $request->procurement_sector ?? 'N/A' }}<br>
                    <strong class="text-inverse">{{ __('Categorization') }}:
                    </strong>{{ getProcurementCategorization($request->contract_value)->categorization }}<br>
                </div>
            </td>

            <td>
                <div>
                    <strong class="text-inverse">{{ __('Financial Year') }}: </strong>
                    {{ $request->financial_year }}<br>
                    <strong class="text-inverse">{{ __('Currency') }}:
                    </strong>{{ $request->currency ?? 'N/A' }}<br>
                    <strong class="text-inverse">{{ __('Budget Line') }}:
                    </strong>{{ $request->budget_line ?? 'N/A' }}<br>
                    <strong class="text-inverse">{{ __('Sequence No') }}:
                    </strong>{{ $request->sequence_number ?? 'N/A' }}<br>
                    <strong class="text-inverse">{{ __('Procurement Plan Reference') }}:
                    </strong>{{ $request->procurement_plan_ref ?? 'N/A' }}
                </div>
            </td>

            <td>
                <div>
                    <strong class="text-inverse">{{ __('Location of Delivery') }}:
                    </strong>{{ $request->location_of_delivery ?? 'N/A' }}<br>
                    <strong class="text-inverse">{{ __('Date Required') }}:
                    </strong>@formatDate($request->date_required ?? now())<br>
                    <strong class="text-inverse">{{ __('Contract Value') }} ({{ $request->currency }}):
                    </strong>@moneyFormat($request->contract_value)<br>
                    <strong class="text-inverse">{{ __('Requested By') }}:
                    </strong>{{ $request->requester->name ?? 'N/A' }}<br>
                    <strong class="text-inverse">{{ __('Status') }}:
                    </strong><span
                        class="badge bg-{{ getProcurementRequestStatusColor($request->status) }}">{{ $request->status }}</span>
                    {{ getProcurementRequestStep($request->step_order) }}
                </div>
            </td>
        </tr>
    </table>

    <div>
        <p class="px-2">{{ $request->body ?? 'N/A' }}</p>
    </div>

    <div>
        <h5 class="px-2">Items</h5>
    </div>

    @if (!$request->items->isEmpty())
        <div class="tab-content scrollable-di">
            <div class="table-responsive">
                <table class="table table-striped mb-0 w-100 sortable border">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('Quantity') }}</th>
                            <th>{{ __('Estimated Unit Cost') }}</th>
                            <th>{{ __('Total Cost') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($request->items as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{!! nl2br(e($item->description)) !!}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>@moneyFormat($item->estimated_unit_cost)</td>
                                <td>@moneyFormat($item->total_cost)</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" class="text-end">Total ({{ $request->currency }})</td>
                            <td>@moneyFormat($request->items->sum('total_cost'))</td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
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

    <div>
        <h5 class="px-2 text-cente">Supporting Documents</h5>
    </div>
    @if (!$request->documents->isEmpty())
        <div class="tab-content scrollable-di">
            <div class="table-responsive">
                <table class="table table-striped mb-0 w-100 sortable border">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('File') }}</th>
                            <th>{{ __('Description') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($request->documents as $key => $document)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $document->document_category }}</td>
                                <td>{{ $document->document_name }}</td>
                                <td>
                                    {{-- {{ $document->document_path }} --}}
                                    @if ($document->document_path != null)
                                        <button wire:click='downloadDocument({{ $document->id }})'
                                            class="btn text-success" title="{{ __('public.download') }}"><i
                                                class="ti ti-download"></i></button>
                                    @else
                                        N/A
                                    @endif

                                </td>
                                <td>{!! nl2br(e($document->description)) !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
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

    <div>
        <h5 class="px-2">Chain of Custody</h5>
    </div>
    @if (!$request->approvals->isEmpty())
        <div class="tab-content scrollable-di">
            <div class="table-responsive">
                <table class="table table-striped mb-0 w-100 sortable border">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>{{ __('Handler') }}</th>
                            <th>{{ __('Step') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Comment') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($request->approvals as $key => $approval)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $approval->approver?->name ?? 'N/A' }}</td>
                                <td>{{ $approval->step }}</td>
                                <td><span
                                        class="badge bg-{{ getProcurementRequestStatusColor($approval->status) }}">{{ $approval->status }}</span>
                                </td>
                                <td>{!! nl2br(e($approval->comment ?? 'N/A')) !!}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    @else<div class="alert border-0 border-start border-5 border-warning alert-dismissible fade show py-2">
            <div class="d-flex align-items-center">
                <div class="font-35 text-warning"><i class='bx bx-primary-circle'></i>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0 text-warning">{{ __('Approvals') }}</h6>
                    <div>{{ __('public.not_found') }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div>
        <h5 class="px-2">Procurement Method Approval</h5>
    </div>
    @include('livewire.procurement.requests.procurement.inc.procurement-method-approval')

    <div>
        <h5 class="px-2">Evaluation Report Approval</h5>
    </div>
    @include('livewire.procurement.requests.procurement.inc.evaluation-approval-information')
</div>
