<div>
    <x-report-layout>
        <h5 class="text-center">{{ $project->name ?? 'N/A' }}
            @if ($project->is_active == 0)
                <span class="badge bg-danger">Suspended</span>
            @else
                <span class="badge bg-success">Active</span>
            @endif
        </h5>

        @include('livewire.grants.projects.inc.project-details')

        <div class="row" x-data="{ active_tab: @entangle('activeTab') }">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <div class="card-bod p-0">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs d-print-none" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" :class="{ 'active': active_tab === 'financials' }"
                                            data-bs-toggle="tab" href="#financials" role="tab" aria-selected="true"
                                            @click="active_tab = 'financials'">Financials</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" :class="{ 'active': active_tab === 'human-resource' }"
                                            data-bs-toggle="tab" href="#human-resource" role="tab"
                                            aria-selected="false" @click="active_tab = 'human-resource'">Human
                                            Resource</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" :class="{ 'active': active_tab === 'procurement' }"
                                            data-bs-toggle="tab" href="#procurement" role="tab"
                                            aria-selected="false" @click="active_tab = 'procurement'">Procurement</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" :class="{ 'active': active_tab === 'assets' }"
                                            data-bs-toggle="tab" href="#assets" role="tab" aria-selected="false"
                                            @click="active_tab = 'assets'">Assets</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" :class="{ 'active': active_tab === 'inventory' }"
                                            data-bs-toggle="tab" href="#inventory" role="tab" aria-selected="false"
                                            @click="active_tab = 'inventory'">Inventory</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" :class="{ 'active': active_tab === 'timesheets' }"
                                            data-bs-toggle="tab" href="#timesheets" role="tab" aria-selected="false"
                                            @click="active_tab = 'timesheets'">Timesheets</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" :class="{ 'active': active_tab === 'documents' }"
                                            data-bs-toggle="tab" href="#documents" role="tab" aria-selected="false"
                                            @click="active_tab = 'documents'">Supporting Documents</a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane p-3 @if ($activeTab == 'financials') active @endif"
                                        id="financials" role="tabpanel">

                                    </div>

                                    <div class="tab-pane p-3 @if ($activeTab == 'human-resource') active @endif"
                                        id="human-resource" role="tabpanel">
                                        @if (!$project->departments->isEmpty())
                                            <div class="card-header">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="card-title">{{ __('Associated Departments') }}</h4>
                                                    </div><!--end col-->
                                                </div> <!--end row-->
                                            </div>

                                            <div class="table-responsive">
                                                <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Name</th>
                                                            <th>Type</th>
                                                            <th>Parent</th>
                                                            <th>Description</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($project->departments as $key => $department)
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>{{ $department->name }}</td>
                                                                <td>{{ $department->type }}</td>
                                                                <td>{{ $department->parent->name??'N/A' }}</td>
                                                                <td>{{ $department->description ?? 'N/A' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> <!-- end preview-->
                                        @endif

                                        @if (!$project->procurementRequests->isEmpty())
                                            <div class="card-header">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="card-title">{{ __('Human Resource') }}</h4>
                                                    </div><!--end col-->
                                                </div> <!--end row-->
                                            </div>

                                            <div class="table-responsive">
                                                <table id="datableButton"
                                                    class="table table-striped mb-0 w-100 sortable">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Employee Name</th>
                                                            <th>Start Date</th>
                                                            <th>End Date</th>
                                                            <th>Gross Salary</th>
                                                            <th>Status</th>
                                                            <th>FTE</th>
                                                            <th>Contract Summary</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($project->employees as $key => $employee)
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>{{ $employee->fullname ?? 'N/A' }}</td>
                                                                <td>@formatDate($employee->pivot->start_date)</td>
                                                                <td>@formatDate($employee->pivot->end_date)</td>
                                                                <td>{{ getCurrencyCode($project->currency_id) }}
                                                                    {{ $employee->pivot->gross_salary ?? 'N/A' }}</td>

                                                                @if ($employee->pivot->status == 'Running')
                                                                    <td><span
                                                                            class="badge bg-success">{{ $employee->pivot->status }}</span>
                                                                    </td>
                                                                @else
                                                                    <td><span
                                                                            class="badge bg-warning">{{ $employee->pivot->status }}</span>
                                                                    </td>
                                                                @endif
                                                                <td>
                                                                    {{ $employee->pivot->fte ?? 'N/A' }}
                                                                </td>
                                                                <td>
                                                                    {{ $employee->pivot->contract_summary }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> <!-- end preview-->
                                        @endif
                                    </div>

                                    <div class="tab-pane p-3 @if ($activeTab == 'procurement') active @endif"
                                        id="procurement" role="tabpanel">
                                        @if (!$project->procurementRequests->isEmpty())
                                            <div class="card-header">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="card-title">{{ __('Procurement History') }}</h4>
                                                    </div><!--end col-->
                                                </div> <!--end row-->
                                            </div>

                                            <div class="table-responsiv">
                                                <table class="table table-striped mb-0 w-100 sortable">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>{{ __('Reference No') }}</th>
                                                            <th>{{ __('Request Type') }}</th>
                                                            <th>{{ __('Source') }}</th>
                                                            <th>{{ __('Category') }}</th>
                                                            <th>{{ __('Contract Value') }}</th>
                                                            <th>{{ __('#Invoice No') }}</th>
                                                            <th>{{ __('#LPO No') }}</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($project->procurementRequests as $key => $procurementRequest)
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>
                                                                    <a href="{{ route('proc-dept-request-details', $procurementRequest->id) }}"
                                                                        target="__blank">{{ $procurementRequest->reference_no }}</a>
                                                                </td>
                                                                <td>{{ $procurementRequest->request_type }}</td>
                                                                <td>{{ $procurementRequest->requestable->name }}</td>
                                                                <td>{{ $procurementRequest->procurement_sector ?? 'N/A' }}
                                                                </td>
                                                                <td>{{ $procurementRequest->currency->code }}
                                                                    @moneyFormat($procurementRequest->contract_value)</td>
                                                                <td>{{ $procurementRequest?->pivot?->invoice_no ?? 'N/A' }}
                                                                </td>
                                                                <td>{{ $procurementRequest?->lpo_no ?? 'N/A' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> <!-- end preview-->
                                        @endif
                                    </div>

                                    <div class="tab-pane p-3 @if ($activeTab == 'assets') active @endif"
                                        id="assets" role="tabpanel">

                                    </div>

                                    <div class="tab-pane p-3 @if ($activeTab == 'inventory') active @endif"
                                        id="inventory" role="tabpanel">

                                    </div>

                                    <div class="tab-pane p-3 @if ($activeTab == 'timesheets') active @endif"
                                        id="timesheets" role="tabpanel">

                                    </div>

                                    <div class="tab-pane p-3 @if ($activeTab == 'documents') active @endif"
                                        id="documents" role="tabpanel">
                                        @if (!$project->documents->isEmpty())
                                            <div class="card-header">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="card-title">{{ __('Documents') }}</h4>
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
                                                            @foreach ($project->documents as $key => $document)
                                                                <tr>
                                                                    <td>{{ $key + 1 }}</td>
                                                                    <td>{{ $document->document_category }}</td>
                                                                    <td>{{ $document->document_name }}</td>
                                                                    <td>
                                                                        {{-- {{ $document->document_path }} --}}
                                                                        @if ($document->document_path != null)
                                                                            <button
                                                                                wire:click='downloadDocument({{ $document->id }})'
                                                                                class="btn text-success"
                                                                                title="{{ __('public.download') }}"><i
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
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>


        <x-slot:action>
            <div class="row d-flex justify-content-center d-print-none">
                <div class="col-lg-12 col-xl-12">
                    <div class="float-end d-print-none mt-2 mt-md-0 mb-2">
                        <a href="javascript:window.print()" class="btn btn-de-info btn-sm">Print</a>
                        <a href="{{ route('manage-projects') }}" class="btn btn-de-primary btn-sm">Back to list</a>
                    </div>
                </div><!--end col-->
            </div><!--end row-->

        </x-slot>
    </x-report-layout>

</div>
