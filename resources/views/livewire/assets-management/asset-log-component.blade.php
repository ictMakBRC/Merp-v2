<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 w-100 sortable">
                            <thead>
                                <tr>
                                    <th>{{ __('Asset Name') }}</th>
                                    {{-- <th>{{ __('Category') }}</th>
                                    <th>{{ __('Classification') }}</th> --}}
                                    <th>{{ __('Brand') }}</th>
                                    <th>{{ __('Model') }}</th>
                                    <th>{{ __('Serial No') }}</th>
                                    <th>{{ __('Barcode') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $asset_name }}</td>
                                    <td>{{ $brand ?? 'N/A' }}</td>
                                    <td>{{ $model ?? 'N/A' }}</td>
                                    <td>{{ $serial_number ?? 'N/A' }}</td>
                                    <td>{{ $barcode ?? 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div> <!-- end preview-->
                </div><!--end card-body-->
            </div> <!--end card-->
        </div><!--end col-->

       
        <hr>
    </div>
</div>
