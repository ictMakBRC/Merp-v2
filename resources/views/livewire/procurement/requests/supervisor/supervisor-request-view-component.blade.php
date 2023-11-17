<?php
use App\Enums\ProcurementRequestEnum;
?>

<div>
    <x-report-layout>
        <h5 class="text-center">{{ $request->subject ?? 'N/A' }}</h5>

        @include('livewire.procurement.requests.inc.request-details')

        <x-slot:action>
            <div class="row d-flex justify-content-center d-print-none">
                {{-- @if ($request->step_order == 2)
                    <div class="col-lg-12 col-xl-12 mb-2 ms-auto float-start">
                        <div class="text-center">
                            <textarea type="text" id="comment" class="form-control" wire:model.defer="comment" placeholder="Enter comment"></textarea>
                            @error('comment')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div><!--end col-->
                @endif --}}
                <div class="col-lg-12 col-xl-12">
                    @if ($request->step_order == 2)
                    <div class="col-lg-12 col-xl-12 mb-2 ms-auto float-start row">
                        <div class="mb-3 col-md-8">
                            <label for="comment" class="form-label required">{{ __('Comment') }}</label>
                            <textarea type="text" id="comment" class="form-control" wire:model.defer="comment" placeholder="Enter comment"></textarea>
                            @error('comment')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2 col-md-4">
                            <label for="contracts_manager_id" class="form-label">{{ __('Contracts Manager') }}</label>
                            <select class="form-select" id="contracts_manager_id"
                                wire:model.lazy="contracts_manager_id">
                                <option selected value="">Select</option>
                                @forelse ($contract_managers as $contract_manager)
                                    <option value="{{ $contract_manager->id }}">{{ $contract_manager->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('contracts_manager_id')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div><!--end col-->
                @endif
                    <div class="float-end d-print-none mt-2 mt-md-0 mb-2">

                        @if ($request->step_order == 2 || ($request->step_order ==2 && $request->status == ProcurementRequestEnum::REJECTED))
                            <x-button class="btn btn-de-success btn-sm"
                                wire:click="approveAndFowardRequest({{ $request->id }},'{{ ProcurementRequestEnum::APPROVED }}')" onclick="return confirm('Are you sure you want to proceed?');">Approve
                                & forward to {{ getProcurementRequestStep($request->step_order + 1) }} </x-button>
                        @endif

                        @if ($request->step_order ==2 && $request->status != ProcurementRequestEnum::REJECTED)
                            <button class="btn btn-de-danger btn-sm"
                                wire:click="approveAndFowardRequest({{ $request->id }},'{{ ProcurementRequestEnum::REJECTED }}')" onclick="return confirm('Are you sure you want to proceed?');">Reject</button>
                        @endif

                        <a href="javascript:window.print()" class="btn btn-de-info btn-sm">Print</a>
                        <a href="{{ route('procurement-supervisor-panel') }}" class="btn btn-de-primary btn-sm">Back to list</a>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </x-slot>
    </x-report-layout>

</div>
