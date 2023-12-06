<?php
use App\Enums\ProcurementRequestEnum;
?>

<div>
    <x-report-layout>
        <h5 class="text-center">{{ $request->subject ?? 'N/A' }}</h5>

        @include('livewire.procurement.requests.inc.request-details')

        <x-slot:action>
            <div class="row d-flex justify-content-center d-print-none">
                @if (
                    $request->items->where('received_status', false)->isEmpty() &&
                        $request->bestBidders->first()->pivot->average_rating &&
                        $request->status == ProcurementRequestEnum::PROCESSING)
                    <div class="col-lg-12 col-xl-12 mb-2 ms-auto float-start">
                        <div class="text-center">
                            <textarea type="text" id="comment" class="form-control" wire:model.defer="comment" placeholder="Enter comment"></textarea>
                            @error('comment')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div><!--end col-->
                @endif
                <div class="col-lg-12 col-xl-12">
                    <div class="float-end d-print-none mt-2 mt-md-0 mb-2">

                        @if (
                            $request->items->where('received_status', false)->isEmpty() &&
                                $request->bestBidders->first()->pivot->average_rating &&
                                $request->status == ProcurementRequestEnum::PROCESSING)
                            <x-button class="btn btn-de-success btn-sm"
                                wire:click="approveAndFowardRequest({{ $request->id }},'{{ ProcurementRequestEnum::PROCESSED }}')"
                                onclick="return confirm('Are you sure you want to proceed?');">
                                Forward to {{ getProcurementRequestStep($request->step_order + 1) }} for Payment
                            </x-button>
                        @endif

                        <a href="javascript:window.print()" class="btn btn-de-info btn-sm">Print</a>
                        <a href="{{ route('contracts-manager-panel') }}" class="btn btn-de-primary btn-sm">Back to
                            list</a>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </x-slot>
    </x-report-layout>

</div>
