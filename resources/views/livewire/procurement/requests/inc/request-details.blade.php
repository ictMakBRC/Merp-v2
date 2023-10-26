<?php
use App\Enums\ProcurementRequestEnum;
?>
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
                    </strong>{{ getProcurementCategorization(exchangeToDefaultCurrency($request->currency_id, $request->contract_value))->categorization }}<br>
                </div>
            </td>

            <td>
                <div>
                    <strong class="text-inverse">{{ __('Financial Year') }}: </strong>
                    {{ $request->financial_year->name }}<br>
                    <strong class="text-inverse">{{ __('Budget Line') }}:
                    </strong>{{ $request->budget_line->name ?? 'N/A' }}<br>
                    <strong class="text-inverse text-info">{{ __('Line Balance') }}:
                    </strong>{{ $request->currency->code }} <strong
                        class="text-danger">{{ $request->budget_line->primary_balance }}</strong><br>
                    <strong class="text-inverse">{{ __('Sequence No') }}:
                    </strong>{{ $request->sequence_number ?? 'N/A' }}<br>
                    <strong class="text-inverse">{{ __('Procurement Plan Reference') }}:
                    </strong>{{ $request->procurement_plan_ref ?? 'N/A' }}<br>
                    <strong class="text-inverse">{{ __('Contracts Manager') }}:
                    </strong>{{ $request->contracts_manager->name ?? 'N/A' }}
                </div>
            </td>

            <td>
                <div>
                    <strong class="text-inverse">{{ __('Location of Delivery') }}:
                    </strong>{{ $request->location_of_delivery ?? 'N/A' }}<br>
                    <strong class="text-inverse">{{ __('Date Required') }}:
                    </strong>@formatDate($request->date_required ?? now())<br>
                    <strong class="text-inverse">{{ __('Contract Value') }} ({{ $request->currency->code }}):
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

    @if (!$request->items->isEmpty() && !$request->items->where('received_status', false)->isEmpty())
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="card-title">{{ __('Items') }}</h4>
                </div><!--end col-->
            </div> <!--end row-->
        </div>
        <div class="tab-content">
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
                            <td colspan="4" class="text-end">Total ({{ $request->currency->code }})</td>
                            <td>@moneyFormat($request->items->sum('total_cost'))</td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @if ($request->items->where('received_status', false)->isEmpty())
        @include('livewire.procurement.requests.stores.inc.items-received')
    @endif

    @if (!$request->documents->isEmpty())
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="card-title">{{ __('Supporting Documents') }}</h4>
                </div><!--end col-->
            </div> <!--end row-->
        </div>

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
    @endif

    @if (!$request->approvals->isEmpty())
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="card-title">{{ __('Chain of Custody') }}</h4>
                </div><!--end col-->
            </div> <!--end row-->
        </div>

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
    @endif

    @if (!$request->decisions->isEmpty())
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="card-title">{{ __('Procurement Method Approval') }}</h4>
                </div><!--end col-->
            </div> <!--end row-->
        </div>
        @include('livewire.procurement.requests.procurement.inc.procurement-method-approval')

        @if (checkProcurementEvaluationApproval($request->id))
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title">{{ __('Evaluation Report Approval') }}</h4>
                    </div><!--end col-->
                </div> <!--end row-->
            </div>
            @include('livewire.procurement.requests.procurement.inc.evaluation-approval-information')
        @endif

    @endif

    @if ($request?->bestBidders?->first()?->pivot->average_rating)
        @include('livewire.procurement.requests.contracts-manager.inc.provider-rating')
    @endif
</div>
