<div class="bg-light">
    <div class="row row-cols-3 d-flex justify-content-md-between p-2">
        <div class="col-md-4 d-print-flex">
            <div>
                <strong class="text-inverse">{{ __('Name') }}:
                </strong>{{ $asset->asset_name ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Classification') }}:
                </strong>{{ $asset->category->classification->name ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Category') }}:
                </strong>{{ $asset->category->name ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Brand') }}:
                </strong>{{ $asset->brand ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Model') }}:
                </strong>{{ $asset->model ?? 'N/A' }}<br>

                <strong class="text-inverse">{{ __('Serial Number') }}:
                </strong>{{ $asset->serial_number ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Barcode') }}:
                </strong>{{ $asset->barcode ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Engraved Label') }}:
                </strong>{{ $asset->engraved_label ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Acquisition Type') }}:
                </strong>{{$asset->acquisition_type}}<br>

            </div>
        </div><!--end col-->
        <div class="col-md-4 d-print-flex">
            <div>
                
                <strong class="text-inverse">{{ __('Procurement Date') }}:
                </strong>@formatDate($asset->procurement_date)<br>
                <strong class="text-inverse">{{ __('Procurement Type') }}:
                </strong>{{ $asset->procurement_type ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Invoice No') }}:
                </strong>{{ $asset->invoice_number ?? 'N/A' }}<br>

                <strong class="text-inverse">{{ __('Purchase Price') }}: </strong>
                @moneyFormat($asset->cost)<br>
                <strong class="text-inverse">{{ __('Supplier') }}: </strong>
                {{ $asset->supplier_id ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Has service contract') }}:
                </strong>{{ $asset->has_service_contract ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Service contract end') }}:
                </strong>@formatDate($asset->has_service_contract_expiry_date)<br>
                <strong class="text-inverse">{{ __('Service Provider') }}: </strong>
                {{ $asset->service_provider ?? 'N/A' }}<br>
            </div>
        </div><!--end col-->

        <div class="col-md-4 d-print-flex">
            <div>

                <strong class="text-inverse">{{ __('Warranty Details') }}:
                </strong>{{ $asset->warranty_details ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Expected Useful Years') }}:
                </strong>{{ $asset->useful_years ?? 'N/A' }}<br>
                
                <strong class="text-inverse">{{ __('Depreciation Method') }}:
                </strong>{{ $asset->depreciation_method ?? 'N/A' }}<br>

                <strong class="text-inverse">{{ __('Salvage Value') }}:
                </strong>{{ $asset->salvage_value ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Asset Condition') }}:
                </strong>{{ $asset->asset_condition ?? 'N/A' }}<br>

                <strong class="text-danger">{{ __('Maintenance Cost') }}:
                </strong>@moneyFormat($asset->logs->where('log_type', 'Maintenance')?->sum('cost')??0)

                
            </div>
        </div><!--end col-->
    </div><!--end row-->
    
    @if ($asset->description != null)
        <table class="table">
            <tr>
                <td>
                    <p>
                        {{ $asset->description ?? 'N/A' }}
                    </p>
                </td>
            </tr>
        </table>
    @endif

</div>
