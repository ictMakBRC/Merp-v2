

<div>
    <x-report-layout>
        <h5 class="text-center">{{ $provider->name ?? 'N/A' }}
            @if ($provider->is_active == 0)
            <span class="badge bg-danger">Suspended</span>
            @else
            <span class="badge bg-success">Active</span>
            @endif
        </h5>

        @include('livewire.procurement.settings.inc.provider-details')

        <x-slot:action>
            <div class="row d-flex justify-content-center d-print-none">
                <div class="col-lg-12 col-xl-12">
                    <div class="float-end d-print-none mt-2 mt-md-0 mb-2">
                        <a href="javascript:window.print()" class="btn btn-de-info btn-sm">Print</a>
                        <a href="{{ route('manage-providers') }}" class="btn btn-de-primary btn-sm">Back to list</a>
                    </div>
                </div><!--end col-->
            </div><!--end row-->

        </x-slot>
    </x-report-layout>

</div>

