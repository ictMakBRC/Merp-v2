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
                        @if ($asset->operational_status == 'Operational')
                            <td><span class="badge bg-success">{{ $asset->operational_status }}</span></td>
                        @elseif ($asset->operational_status == 'In-Stock')
                            <td><span class="badge bg-info">{{ $asset->operational_status }}</span></td>
                        @else
                            <td><span class="badge bg-danger">{{ $asset->operational_status }}</span></td>
                        @endif
                        <td>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-sm btn-outline-success m-1"
                                    wire:click="editData({{ $asset->id }})" title="{{ __('public.edit') }}">
                                    <i class="ti ti-edit fs-18"></i></button>
                                <a href="{{ route('asset-details', $asset->id) }}"
                                    class="btn btn-sm btn-outline-info m-1" title="{{ __('public.view') }}"> <i
                                        class="ti ti-eye"></i></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div> <!-- end preview-->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="btn-group float-end">
                {{ $assets->links('vendor.livewire.bootstrap') }}
            </div>
        </div>
    </div>
</div> <!-- end tab-content-->
