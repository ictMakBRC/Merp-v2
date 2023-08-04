<div class="tab-content">
    @include('livewire.assets-management.inc.filter')

    <div class="table-responsive">
        <table class="table table-striped mb-0 w-100 sortable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>{{ __('Asset') }}</th>
                    <th>{{ __('Category') }}</th>
                    <th>{{ __('Classification') }}</th>
                    <th>{{ __('Brand') }}</th>
                    <th>{{ __('Model') }}</th>
                    <th>{{ __('Serial No') }}</th>
                    <th>{{ __('Acquisition Type') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($assets as $key => $asset)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $asset->asset_name }}</td>
                        <td>{{ $asset->category->name ?? 'N/A' }}</td>
                        <td>{{ $asset->category->classification->name ?? 'N/A' }}</td>
                        <td>{{ $asset->brand ?? 'N/A' }}</td>
                        <td>{{ $asset->model ?? 'N/A' }}</td>
                        <td>{{ $asset->serial_number ?? 'N/A' }}</td>
                        <td>{{ $asset->acquisition_type ?? 'N/A' }}</td>
                        @if ($asset->operational_status == 0)
                            <td><span class="badge bg-warning">Not Operational</span></td>
                        @elseif($asset->operational_status == 1)
                            <td><span class="badge bg-success">Operational</span></td>
                        @else
                            <td><span class="badge bg-danger">Retired</span></td>
                        @endif
                        <td>
                            <button class="btn btn btn-sm btn-outline-success" wire:click="editData({{ $asset->id }})" data-bs-toggle="tooltip" data-bs-placement="right" title="{{__('public.edit')}}" data-bs-trigger="hover">
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
                {{ $assets->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div> <!-- end tab-content-->
