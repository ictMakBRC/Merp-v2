<div>
    <x-report-layout>
        <h5 class="text-center">{{ $asset->asset_name ?? 'N/A' }}
            @if ($asset->operational_status)
                <span class="badge bg-success">Operational</span>
            @else
                <span class="badge bg-danger">Retired</span>
            @endif
        </h5>
        @include('livewire.assets-management.inc.asset-details')

        <div class="row" x-data="{ active_tab: @entangle('activeTab') }">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-ligh d-print-none">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title"></h4>
                            </div><!--end col-->
                            <div class="col-auto">
                                <div class="dropdown">
                                    <a href="#" class="btn btn-sm btn-outline-info dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        More...<i class="las la-angle-down ms-1"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#assetLoggerModal">Create Log</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#assetDocumentModal">Upload Document</a>
                                    </div>
                                </div>
                            </div><!--end col-->
                        </div> <!--end row-->
                    </div><!--end card-header-->
                    <div class="card-body">
                        <div>
                            <div class="card-bod p-0">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs d-print-none" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" :class="{ 'active': active_tab === 'breakdown' }"
                                            data-bs-toggle="tab" href="#breakdown" role="tab" aria-selected="true"
                                            @click="active_tab = 'breakdown'">Breakdown Information</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" :class="{ 'active': active_tab === 'maintenance' }"
                                            data-bs-toggle="tab" href="#maintenance" role="tab"
                                            aria-selected="false" @click="active_tab = 'maintenance'">Maintenance
                                            Information</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" :class="{ 'active': active_tab === 'assignment' }"
                                            data-bs-toggle="tab" href="#assignment" role="tab" aria-selected="false"
                                            @click="active_tab = 'assignment'">Assignment History</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" :class="{ 'active': active_tab === 'documents' }"
                                            data-bs-toggle="tab" href="#documents" role="tab" aria-selected="false"
                                            @click="active_tab = 'documents'">Supporting Documents</a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane p-0 @if ($activeTab == 'breakdown') active @endif"
                                        id="breakdown" role="tabpanel">
                                        @if (!$asset->logs->where('log_type', 'Breakdown')->isEmpty())
                                            <div class="card-header">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="card-title">{{ __('Breakdown Information') }}</h4>
                                                    </div><!--end col-->
                                                </div> <!--end row-->
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-striped mb-0 w-100 sortable border">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>{{ __('Breakdown Number') }}</th>
                                                            <th>{{ __('Type') }}</th>
                                                            <th>{{ __('Date') }}</th>
                                                            <th>{{ __('Description') }}</th>
                                                            <th>{{ __('Action Taken') }}</th>
                                                            <th>{{ __('Breakdown Status') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($asset->logs->where('log_type', 'Breakdown') as $key => $breakdown)
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>{{ $breakdown->breakdown_number }}</td>
                                                                <td>{{ $breakdown->breakdown_type }}</td>
                                                                <td>@formatDate($breakdown->breakdown_date)</td>
                                                                <td>{!! nl2br(e($breakdown->breakdown_description)) !!}</td>
                                                                <td>{!! nl2br(e($breakdown->action_taken)) !!}</td>
                                                                <td>
                                                                    {{-- {{ $document->document_path }} --}}
                                                                    @if ($breakdown->breakdown_status == 'Fixed')
                                                                        <span class="badge bg-success"><i
                                                                                class="ti ti-tool"></i>{{ $breakdown->breakdown_status }}</span>
                                                                    @else
                                                                        <span class="badge bg-warning"><i
                                                                                class="ti ti-alert-triangle"></i>{{ $breakdown->breakdown_status }}</span>
                                                                    @endif

                                                                </td>

                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="alert alert-outline-info mb-0" role="alert">
                                                <strong>Not Found!</strong> No Breakdown Information found here. 
                                            </div>
                                        @endif
                                    </div>

                                    <div class="tab-pane p-0 @if ($activeTab == 'maintenance') active @endif"
                                        id="maintenance" role="tabpanel">
                                        @if (!$asset->logs->where('log_type', 'Maintenance')->isEmpty())
                                            <div class="card-header">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="card-title">{{ __('Maintenance Information') }}</h4>
                                                    </div><!--end col-->
                                                </div> <!--end row-->
                                            </div>

                                            <div class="table-responsiv">
                                                <table class="table table-striped mb-0 w-100 sortable border">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>{{ __('Breakdown Number') }}</th>
                                                            <th>{{ __('Service Type') }}</th>
                                                            <th>{{ __('Date Serviced') }}</th>
                                                            <th>{{ __('Service Action') }}</th>
                                                            <th>{{ __('Recommendations') }}</th>
                                                            <th>{{ __('Cost') }}</th>
                                                            <th>{{ __('Resolution Status') }}</th>
                                                            <th>{{ __('Next Service Date') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($asset->logs->where('log_type', 'Maintenance') as $key => $maintenance)
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>{{ $maintenance->breakdown_number }}</td>
                                                                <td>{{ $maintenance->service_type }}</td>
                                                                <td>@formatDate($maintenance->date_serviced)</td>
                                                                <td>{!! nl2br(e($maintenance->service_action)) !!}</td>
                                                                <td>{!! nl2br(e($maintenance->service_recommendations)) !!}</td>
                                                                <td>@moneyFormat($maintenance->cost)</td>
                                                                <td>
                                                                    {{-- {{ $document->document_path }} --}}
                                                                    @if ($maintenance->resolution_status == 'Fully Fixed')
                                                                        <span class="badge bg-success"><i
                                                                                class="ti ti-tool"></i>{{ $maintenance->resolution_status }}</span>
                                                                    @else
                                                                        <span class="badge bg-warning"><i
                                                                                class="ti ti-alert-triangle"></i>{{ $maintenance->resolution_status }}</span>
                                                                    @endif

                                                                </td>
                                                                <td>@formatDate($maintenance->next_service_date)</td>

                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="alert alert-outline-info mb-0" role="alert">
                                                <strong>Not Found!</strong> No Maintenance Information found yet. 
                                            </div>
                                        @endif
                                    </div>

                                    <div class="tab-pane p-0 @if ($activeTab == 'assignment') active @endif"
                                        id="assignment" role="tabpanel">
                                        @if (!$asset->logs->where('log_type', 'Allocation')->isEmpty())
                                            <div class="card-header">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="card-title">{{ __('Allocation Information') }}</h4>
                                                    </div><!--end col-->
                                                </div> <!--end row-->
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-striped mb-0 w-100 sortable border">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>{{ __('Station') }}</th>
                                                            <th>{{ __('Department/Project/Study') }}</th>
                                                            <th>{{ __('Employee') }}</th>
                                                            <th>{{ __('Date Allocated') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($asset->logs->where('log_type', 'Allocation') as $key => $assignment)
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>{{ $assignment->station?->name??'N/A' }}</td>
                                                                <td>{{ $assignment->department?->name??'N/A' }}</td>
                                                                <td>{{ $assignment->employee?->fullName??'N/A' }}</td>
                                                                <td>@formatDate($assignment->date_allocated)</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="alert alert-outline-info mb-0" role="alert">
                                                <strong>Not Found!</strong> No Assigment Information found yet. 
                                            </div>
                                        @endif
                                    </div>

                                    <div class="tab-pane p-0 @if ($activeTab == 'documents') active @endif"
                                        id="documents" role="tabpanel">
                                        @if (!$asset->documents->isEmpty())
                                            <div class="card-header">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="card-title">{{ __('Documents') }}</h4>
                                                    </div><!--end col-->
                                                </div> <!--end row-->
                                            </div>

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
                                                        @foreach ($asset->documents as $key => $document)
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
                                        @else
                                            <div class="alert alert-outline-info mb-0" role="alert">
                                                <strong>Not Found!</strong> No Documents found yet.
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
                        <a href="{{ route('asset-catalog') }}" class="btn btn-de-primary btn-sm">Back to list</a>
                    </div>
                </div><!--end col-->
            </div><!--end row-->

        </x-slot>
    </x-report-layout>

    @include('livewire.assets-management.inc.asset-logger-modal')
    @include('livewire.assets-management.inc.asset-document-modal')
</div>
