<?php
use App\Enums\ProcurementRequestEnum;
?>

<div>
    <x-report-layout>
        <h5 class="text-center">{{ $request->subject ?? 'N/A' }}</h5>

        @include('livewire.procurement.requests.inc.request-details')

        <x-slot:action>
            <div class="row d-flex justify-content-center d-print-none">
                <div class="col-lg-12 col-xl-12">
                    <div class="float-end d-print-none mt-2 mt-md-0 mb-2">

                        @if ($request->step_order == 6 && $request->status == ProcurementRequestEnum::PENDING)
                            <x-button class="btn btn-de-success btn-sm"
                                wire:click="acknowledgeRequest({{ $request->id }},'{{ ProcurementRequestEnum::PROCESSING }}')">Acknowledge
                                & Process</x-button>
                        @endif

                        <a href="javascript:window.print()" class="btn btn-de-info btn-sm">Print</a>
                        <a href="{{ route('procurement-office-panel') }}" class="btn btn-de-primary btn-sm">Back to list</a>
                    </div>
                </div><!--end col-->
            </div><!--end row-->

        </x-slot>
    </x-report-layout>

</div>
