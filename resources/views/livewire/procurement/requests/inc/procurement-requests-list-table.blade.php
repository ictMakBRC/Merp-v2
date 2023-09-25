<div class="tab-content">
    {{-- @include('livewire.procurement.requests.inc.filter') --}}

    <div class="table-responsive">
        <table class="table table-striped mb-0 w-100 sortable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>{{ __('Reference No') }}</th>
                    <th>{{ __('Requester Type') }}</th>
                    <th>{{ __('Source') }}</th>
                    <th>{{ __('Subject') }}</th>
                    <th>{{ __('Category') }}</th>
                    <th>{{ __('Date Required') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('public.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($procurementRequests as $key => $procurementRequest)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $procurementRequest->reference_no }}</td>
                        <td>{{ $procurementRequest->request_type }}</td>
                        <td>{{ $procurementRequest->requestable->name }}</td>
                        <td>{{ $procurementRequest->subject }}</td>
                        <td>{{ $procurementRequest->procurement_sector ?? 'N/A' }}</td>
                        <td>@formatDate($procurementRequest->date_required)</td>
                        <td><span class="badge bg-info">{{ $procurementRequest->status }}</span></td>
                        <td>
                            <button class="btn btn btn-sm btn-outline-success"
                                wire:click="loadRequest({{ $procurementRequest->id }})" data-bs-toggle="tooltip"
                                data-bs-placement="right" title="{{ __('public.edit') }}" data-bs-trigger="hover">
                                <i class="ti ti-edit fs-18"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div> <!-- end preview-->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="btn-group float-end">
                {{ $procurementRequests->links('vendor.livewire.bootstrap') }}
            </div>
        </div>
    </div>
</div> <!-- end tab-content-->
